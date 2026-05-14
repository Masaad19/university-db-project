<?php
session_start();

$conn = new mysqli("localhost","root","","university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

$student_id = $_SESSION['student_id'];

$sql = "
SELECT 
    t.topic_id,
    t.course_id,
    t.title,
    t.description
FROM enrollment e
JOIN topic t
ON e.course_id = t.course_id
WHERE e.student_id = '$student_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Topics</title>

<style>
body{margin:0;font-family:Segoe UI;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white}
.header{text-align:center;padding:20px;font-size:28px;font-weight:bold}
.container{padding:20px}
.card{background:rgba(255,255,255,0.1);padding:15px;border-radius:10px;margin-bottom:12px}
</style>
</head>

<body>

<div class="header">📖 My Topics</div>

<div class="container">

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
        echo "
        <div class='card'>
            <p><b>Topic ID:</b> {$row['topic_id']}</p>
            <p><b>Course ID:</b> {$row['course_id']}</p>
            <p><b>Title:</b> {$row['title']}</p>
            <p><b>Description:</b> {$row['description']}</p>
        </div>";
    }

}else{
    echo "<p>No topics found.</p>";
}
?>

</div>

</body>
</html>