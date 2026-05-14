<?php
session_start();

$conn = new mysqli("localhost", "root", "", "university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "
SELECT
    q.question_id,
    q.title,
    q.content AS question_content,
    a.content AS answer_content,
    a.created_at AS answer_date
FROM question q
LEFT JOIN answer a
ON q.question_id = a.question_id
WHERE q.student_id = ?
ORDER BY q.created_at DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>View Answers</title>

<style>
body{
    margin:0;
    font-family:Segoe UI;
    background:linear-gradient(135deg,#1e3c72,#2a5298);
    color:white;
}

.header{
    text-align:center;
    padding:20px;
    font-size:28px;
    font-weight:bold;
}

.container{
    padding:20px;
}

.card{
    background:rgba(255,255,255,0.1);
    padding:15px;
    border-radius:10px;
    margin-bottom:15px;
}

.answer{
    margin-top:10px;
    padding:10px;
    background:rgba(255,255,255,0.08);
    border-radius:8px;
}

.date{
    margin-top:8px;
    font-size:14px;
    opacity:0.8;
}
</style>
</head>

<body>

<div class="header">
👀 View Answers
</div>

<div class="container">

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
?>

<div class="card">

    <p>
        <b>Question Title:</b>
        <?php echo htmlspecialchars($row['title']); ?>
    </p>

    <p>
        <b>Your Question:</b>
        <?php echo htmlspecialchars($row['question_content']); ?>
    </p>

    <div class="answer">

        <p><b>Instructor Answer:</b></p>

        <p>
            <?php
            if(!empty($row['answer_content'])){
                echo htmlspecialchars($row['answer_content']);
            }else{
                echo "No answer yet ⏳";
            }
            ?>
        </p>

        <?php if(!empty($row['answer_date'])){ ?>
            <div class="date">
                Answered at:
                <?php echo htmlspecialchars($row['answer_date']); ?>
            </div>
        <?php } ?>

    </div>

</div>

<?php
    }

}else{
    echo "<p>No questions found.</p>";
}
?>

</div>

</body>
</html>