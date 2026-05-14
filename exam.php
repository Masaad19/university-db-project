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

if (!isset($_SESSION['student_id'])) {
    die("Please login first");
}

$student_id = $_SESSION['student_id'];

$sql = "
SELECT DISTINCT
    e.exam_id,
    e.course_id,
    e.title,
    e.exam_date,
    e.total_marks,
    e.exam_type,
    c.course_name
FROM exam e

INNER JOIN course c
ON e.course_id = c.course_id

INNER JOIN enrollment en
ON en.course_id = e.course_id

WHERE en.student_id = ?
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $student_id);

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

<title>My Exams</title>

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

</style>

</head>

<body>

<div class="header">
📘 My Exams
</div>

<div class="container">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "

        <div class='card'>

            <p><b>Exam ID:</b> "
            . htmlspecialchars($row['exam_id']) .
            "</p>

            <p><b>Course:</b> "
            . htmlspecialchars($row['course_name']) .
            "</p>

            <p><b>Course ID:</b> "
            . htmlspecialchars($row['course_id']) .
            "</p>

            <p><b>Title:</b> "
            . htmlspecialchars($row['title']) .
            "</p>

            <p><b>Date:</b> "
            . htmlspecialchars($row['exam_date']) .
            "</p>

            <p><b>Total Marks:</b> "
            . htmlspecialchars($row['total_marks']) .
            "</p>

            <p><b>Type:</b> "
            . htmlspecialchars($row['exam_type']) .
            "</p>

        </div>
        ";
    }

}else{

    echo "<p>No exams available.</p>";
}
?>

</div>

</body>

</html>