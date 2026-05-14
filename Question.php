<?php
session_start();

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "university_academic_support_system"
);

if ($conn->connect_error) {
    die("Connection failed");
}

$message = "";

if (!isset($_SESSION['student_id'])) {
    die("Please login first");
}

$student_id = $_SESSION['student_id'];

if (isset($_POST['submit_question'])) {

    $course_id = intval($_POST['course_id']);
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if ($title == "" || $content == "") {

        $message = "Please fill all fields.";

    } else {

        $check_sql = "
            SELECT 1
            FROM enrollment
            WHERE student_id = ?
            AND course_id = ?
        ";

        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ii", $student_id, $course_id);
        $stmt->execute();
        $check_result = $stmt->get_result();

        if ($check_result->num_rows == 0) {

            $message = "You can only ask questions in your registered courses.";

        } else {

            $insert_sql = "
                INSERT INTO question
                (student_id, course_id, title, content, created_at, status)
                VALUES
                (?, ?, ?, ?, NOW(), 'open')
            ";

            $stmt = $conn->prepare($insert_sql);
            $stmt->bind_param("iiss", $student_id, $course_id, $title, $content);

            if ($stmt->execute()) {
                $message = "Question submitted successfully 📩";
            } else {
                $message = "Error submitting question.";
            }
        }
    }
}

$courses_sql = "
    SELECT DISTINCT c.course_id, c.course_name
    FROM enrollment e
    INNER JOIN course c 
    ON e.course_id = c.course_id
    WHERE e.student_id = ?
    ORDER BY c.course_name
";

$stmt = $conn->prepare($courses_sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$courses_result = $stmt->get_result();

$has_courses = $courses_result->num_rows > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Question</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
}

.header {
    text-align: center;
    padding: 20px;
    font-size: 28px;
    font-weight: bold;
}

.container {
    max-width: 600px;
    margin: auto;
    padding: 20px;
}

.card {
    background: rgba(255,255,255,0.08);
    padding: 20px;
    border-radius: 15px;
}

label {
    display: block;
    margin-top: 10px;
    margin-bottom: 5px;
}

input, select, textarea {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: none;
    margin-bottom: 10px;
    font-size: 14px;
    box-sizing: border-box;
}

textarea {
    resize: none;
    height: 120px;
}

button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: #4facfe;
    color: white;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #00c6ff;
}

button:disabled {
    background: gray;
    cursor: not-allowed;
}

.message {
    background: rgba(255,255,255,0.15);
    padding: 12px;
    border-radius: 10px;
    margin-bottom: 15px;
    font-weight: bold;
}
</style>

</head>

<body>

<div class="header">
Ask a Question
</div>

<div class="container">
<div class="card">

<?php
if ($message != "") {
    echo "<div class='message'>" . htmlspecialchars($message) . "</div>";
}
?>

<form method="POST">

<label>Course</label>

<select name="course_id" required>
<?php
if ($has_courses) {

    while ($course = $courses_result->fetch_assoc()) {
        echo "<option value='" . htmlspecialchars($course['course_id']) . "'>"
            . htmlspecialchars($course['course_name']) .
            "</option>";
    }

} else {
    echo "<option disabled selected>No registered courses available</option>";
}
?>
</select>

<label>Question Title</label>

<input
    type="text"
    name="title"
    placeholder="Enter question title"
    required
>

<label>Details</label>

<textarea
    name="content"
    placeholder="Explain your question..."
    required
></textarea>

<button
    type="submit"
    name="submit_question"
    <?php if (!$has_courses) echo "disabled"; ?>
>
Submit Question
</button>

</form>

</div>
</div>

</body>
</html>