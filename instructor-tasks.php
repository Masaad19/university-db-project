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

$instructor_id = $_SESSION['instructor_id'];

$sql = "
SELECT 
    t.task_id,
    t.course_id,
    t.title,
    t.description,
    t.due_date,
    c.course_name
FROM task t
JOIN course c
ON t.course_id = c.course_id
WHERE c.instructor_id = '$instructor_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Instructor Tasks</title>

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

<div class="header">📋 My Tasks</div>

<div class="container">

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "
        <div class='card'>
            <p><b>Task ID:</b> {$row['task_id']}</p>
            <p><b>Course:</b> {$row['course_name']}</p>
            <p><b>Course ID:</b> {$row['course_id']}</p>
            <p><b>Title:</b> {$row['title']}</p>
            <p><b>Description:</b> {$row['description']}</p>
            <p><b>Due Date:</b> {$row['due_date']}</p>
        </div>
        ";
    }

}else{
    echo "<p>No tasks found for your courses.</p>";
}
?>

</div>

</body>
</html>