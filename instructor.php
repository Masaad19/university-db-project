<?php
session_start();

if(!isset($_SESSION['instructor_id'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Instructor Dashboard</title>

<link rel="stylesheet" href="student.css">

</head>

<body>

<header class="navbar">

    <div class="logo">
        UASS
    </div>

    <nav>
        <a href="#">About Us</a>
        <a href="#">Contact Us</a>
    </nav>

</header>

<div class="container">

    <h1>Instructor Dashboard</h1>

<div class="grid">

    <a class="card" href="coursesinst.php">
        📚 My Courses
    </a>

    <a class="card" href="create-exam.php">
        📝 Create Exam
    </a>

   <a class="card" href="manage-exams.php">
    📊 Manage Exams
    </a>
    <a class="card" href="upload-material.php">
        📂 Upload Materials
    </a>

    <a class="card" href="support-materials.php">
        🧾 Support Materials
    </a>

    <a class="card" href="answer-questions.php">
        ❓ Answer Questions
    </a>

    <a class="card" href="instructor-tasks.php">
        📋 Tasks
    </a>

  <a class="card" href="student-marks.php">
    🏆 Student Marks
    </a>
    <a class="card" href="change-password.php">
    🔐 Change Password
   </a>
</div>

</div>

</body>
</html>