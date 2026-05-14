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
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "
SELECT DISTINCT
    m.material_id,
    m.title,
    m.description,
    m.upload_date,
    m.file_link,
    c.course_name

FROM material m

INNER JOIN enrollment e
ON m.course_id = e.course_id

INNER JOIN course c
ON m.course_id = c.course_id

WHERE e.student_id = ?

ORDER BY m.material_id
";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $student_id);

$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>

<title>Materials</title>

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
    padding:20px;
    border-radius:15px;
    margin-bottom:15px;
}

.btn{
    display:inline-block;
    margin-top:10px;
    padding:10px 18px;
    background:#4facfe;
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
}

.btn:hover{
    background:#00c6ff;
}

</style>

</head>

<body>

<div class="header">
📁 Materials
</div>

<div class="container">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "

        <div class='card'>

            <p>
                <b>Material ID:</b>
                ". htmlspecialchars($row['material_id']) ."
            </p>

            <p>
                <b>Course:</b>
                ". htmlspecialchars($row['course_name']) ."
            </p>

            <p>
                <b>Title:</b>
                ". htmlspecialchars($row['title']) ."
            </p>

            <p>
                <b>Description:</b>
                ". htmlspecialchars($row['description']) ."
            </p>

            <p>
                <b>Upload Date:</b>
                ". htmlspecialchars($row['upload_date']) ."
            </p>

            <a class='btn' href='". htmlspecialchars($row['file_link']) ."' target='_blank'>
                Open PDF
            </a>

        </div>
        ";
    }

}else{

    echo "<p>No materials available for your courses.</p>";
}

?>

</div>

</body>

</html>