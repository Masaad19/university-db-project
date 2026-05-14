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

/* CHECK LOGIN */

if (!isset($_SESSION['instructor_id'])) {
    header("Location: login.php");
    exit();
}

/* CURRENT INSTRUCTOR */

$instructor_id = $_SESSION['instructor_id'];

/* SHOW ONLY THIS INSTRUCTOR EXAMS */

$sql = "
SELECT
    e.exam_id,
    e.course_id,
    c.course_name,
    e.title,
    e.exam_date,
    e.total_marks,
    e.exam_type

FROM exam e

INNER JOIN course c
ON e.course_id = c.course_id

WHERE c.instructor_id = ?

ORDER BY e.exam_date
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $instructor_id);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Exams</title>

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

button{
    padding:8px 15px;
    border:none;
    border-radius:8px;
    background:#4facfe;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#00c6ff;
}

</style>

</head>

<body>

<div class="header">
📊 Manage Exams
</div>

<div class="container">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "

        <div class='card'>

            <p>
                <b>Exam ID:</b>
                " . htmlspecialchars($row['exam_id']) . "
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
                <b>Title:</b>
                " . htmlspecialchars($row['title']) . "
            </p>

            <p>
                <b>Date:</b>
                " . htmlspecialchars($row['exam_date']) . "
            </p>

            <p>
                <b>Total Marks:</b>
                " . htmlspecialchars($row['total_marks']) . "
            </p>

            <p>
                <b>Type:</b>
                " . htmlspecialchars($row['exam_type']) . "
            </p>

            <button>Edit</button>
            <button>Delete</button>

        </div>
        ";
    }

}else{

    echo "<p>No exams found for your courses.</p>";
}

?>

</div>

</body>

</html>