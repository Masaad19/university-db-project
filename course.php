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

$student_id = $_SESSION['student_id'];

$sql = "
SELECT 
    c.course_id,
    c.course_name,
    c.credit_hours,
    i.name AS instructor_name

FROM enrollment e

JOIN course c
ON e.course_id = c.course_id

LEFT JOIN instructor i
ON c.instructor_id = i.instructor_id

WHERE e.student_id = '$student_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Courses</title>

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
    transition:0.3s;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
}

.course-card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.18);
}

.course-image{
    width:130px;
    height:130px;
    object-fit:cover;
    border-radius:15px;
    margin-bottom:15px;
}

.course-card h2{
    margin:10px 0;
    font-size:24px;
}

.course-card p{
    font-size:18px;
}

</style>

</head>

<body>

<div class="header">
📚 My Courses
</div>

<div class="container">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        $image = "course.png";

        if($row['course_name'] == "Database Systems"){
            $image = "database.jpg";
        }

        elseif($row['course_name'] == "Electronic Circuits Lab"){
             $image = "circuits.jpg";
        }

        elseif($row['course_name'] == "Image Processing"){
             $image = "imageprocessing.jpg";
        }

        elseif($row['course_name'] == "Discrete Mathematics"){
             $image = "discrete.jpg";
        }

        elseif($row['course_name'] == "Microprocessors"){
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

            <img
                src='images/$image'
                class='course-image'
            >

            <h2>{$row['course_name']}</h2>

            <p>
                <b>Course ID:</b>
                {$row['course_id']}
            </p>

            <p>
                <b>Credit Hours:</b>
                {$row['credit_hours']}
            </p>

            <p>
                <b>Instructor:</b>
                {$row['instructor_name']}
            </p>

        </div>

        ";
    }

}else{

    echo "<p>No courses found.</p>";
}

?>

</div>

</body>
</html>