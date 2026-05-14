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

if(!isset($_SESSION['instructor_id'])){
    echo "Please login as instructor first.";
    exit();
}

$instructor_id = $_SESSION['instructor_id'];

$sql = "
SELECT
    course_id,
    course_name,
    credit_hours
FROM course
WHERE instructor_id = '$instructor_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Instructor Courses</title>

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
    padding:30px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}
.course-card{
    background:rgba(255,255,255,0.1);
    padding:20px;
    border-radius:18px;
    text-align:center;
}
.course-image{
    width:130px;
    height:130px;
    object-fit:cover;
    border-radius:15px;
    margin-bottom:15px;
}
</style>
</head>

<body>

<div class="header">📚 My Courses</div>

<div class="container">

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        $image = "course.png";

        if($row['course_name'] == "Database Systems"){
            $image = "database.jpg";
        }elseif($row['course_name'] == "Electronic Circuits Lab"){
            $image = "circuits.jpg";
        }elseif($row['course_name'] == "Image Processing"){
            $image = "imageprocessing.jpg";
        }elseif($row['course_name'] == "Discrete Mathematics"){
            $image = "discrete.jpg";
        }elseif($row['course_name'] == "Microprocessors"){
            $image = "micro.jpg";
        }
    elseif($row['course_name'] == "Oral Surgery Basics"){
             $image = "oral.jpg";
        }

        elseif($row['course_name'] == "Human Anatomy"){
             $image = "anatomy.jpg";
        }

        elseif($row['course_name'] == "Pharmacology I"){
             $image = "pharma.jpg";
        }
        echo "
        <div class='course-card'>
            <img src='images/$image' class='course-image'>
            <h2>{$row['course_name']}</h2>
            <p><b>Course ID:</b> {$row['course_id']}</p>
            <p><b>Credit Hours:</b> {$row['credit_hours']}</p>
        </div>
        ";
    }

}else{
    echo "<p>No courses found for this instructor.</p>";
}
?>

</div>

</body>
</html>