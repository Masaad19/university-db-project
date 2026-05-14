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
    m.student_id,
    m.course_id,
    c.course_name,
    m.score
FROM marks m

INNER JOIN course c
ON m.course_id = c.course_id

INNER JOIN enrollment en
ON en.student_id = m.student_id
AND en.course_id = m.course_id

WHERE m.student_id = ?

ORDER BY c.course_name
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $student_id);

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

<title>Student Marks</title>

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
    margin-bottom:12px;
}

</style>

</head>

<body>

<div class="header">
🏆 My Marks
</div>

<div class="container">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "

        <div class='card'>

            <p>
                <b>Student ID:</b>
                " . htmlspecialchars($row['student_id']) . "
            </p>

            <p>
                <b>Course ID:</b>
                " . htmlspecialchars($row['course_id']) . "
            </p>

            <p>
                <b>Course:</b>
                " . htmlspecialchars($row['course_name']) . "
            </p>

            <p>
                <b>Score:</b>
                " . htmlspecialchars($row['score']) . "
            </p>

        </div>
        ";
    }

}else{

    echo "<p>No marks found.</p>";
}

?>

</div>

</body>

</html>