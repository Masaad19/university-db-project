<?php
session_start();

$conn = new mysqli("localhost", "root", "", "university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

if (!isset($_SESSION['instructor_id'])) {
    header("Location: login.php");
    exit();
}

$instructor_id = $_SESSION['instructor_id'];
$message = "";

if(isset($_POST['submit_answer'])){

    $question_id = intval($_POST['question_id']);
    $answer_content = trim($_POST['answer_content']);

    if($answer_content == ""){
        $message = "Please write an answer.";
    } else {

        $check_sql = "
        SELECT q.question_id
        FROM question q
        INNER JOIN course c ON q.course_id = c.course_id
        WHERE q.question_id = ?
        AND c.instructor_id = ?
        ";

        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ii", $question_id, $instructor_id);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if($check_result->num_rows == 0){

            $message = "You can only answer questions for your courses.";

        } else {

            $insert_sql = "
            INSERT INTO answer
            (question_id, instructor_id, content, created_at)
            VALUES
            (?, ?, ?, NOW())
            ";

            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("iis", $question_id, $instructor_id, $answer_content);

            if($stmt->execute()){

                $update_sql = "
                UPDATE question
                SET status = 'answered'
                WHERE question_id = ?
                ";

                $stmt2 = $conn->prepare($update_sql);
                $stmt2->bind_param("i", $question_id);
                $stmt2->execute();

                $message = "Answer submitted successfully ✅";

            } else {
                $message = "Error submitting answer.";
            }
        }
    }
}

$sql = "
SELECT
    q.question_id,
    q.title,
    q.content,
    q.course_id,
    c.course_name
FROM question q
INNER JOIN course c
ON q.course_id = c.course_id
LEFT JOIN answer a
ON q.question_id = a.question_id
WHERE c.instructor_id = ?
AND a.answer_id IS NULL
ORDER BY q.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $instructor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Answer Questions</title>

<style>
body{margin:0;font-family:Segoe UI;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white}
.header{text-align:center;padding:20px;font-size:28px;font-weight:bold}
.container{padding:20px}
.message{background:rgba(255,255,255,0.15);padding:12px;border-radius:10px;margin-bottom:15px;font-weight:bold}
.card{background:rgba(255,255,255,0.1);padding:15px;border-radius:10px;margin-bottom:15px}
textarea{width:100%;padding:10px;border:none;border-radius:8px;margin-top:10px;box-sizing:border-box}
button{margin-top:10px;padding:10px;border:none;border-radius:8px;background:#4facfe;color:white;font-weight:bold;cursor:pointer}
</style>
</head>

<body>

<div class="header">❓ Answer Questions</div>

<div class="container">

<?php
if($message != ""){
    echo "<div class='message'>" . htmlspecialchars($message) . "</div>";
}

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
?>

<div class="card">

    <p><b>Question ID:</b> <?php echo htmlspecialchars($row['question_id']); ?></p>
    <p><b>Course:</b> <?php echo htmlspecialchars($row['course_name']); ?></p>
    <p><b>Title:</b> <?php echo htmlspecialchars($row['title']); ?></p>
    <p><b>Question:</b> <?php echo htmlspecialchars($row['content']); ?></p>

    <form method="POST">
        <input type="hidden" name="question_id" value="<?php echo htmlspecialchars($row['question_id']); ?>">

        <textarea name="answer_content" placeholder="Write answer" required></textarea>

        <button type="submit" name="submit_answer">
            Submit
        </button>
    </form>

</div>

<?php
    }

}else{
    echo "<p>No unanswered questions found for your courses.</p>";
}
?>

</div>

</body>
</html>