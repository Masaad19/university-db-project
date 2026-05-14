<?php
session_start();

$conn = new mysqli("localhost", "root", "", "university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

$instructor_id = $_SESSION['instructor_id'];

if(isset($_POST['create'])){

    $course_id = $_POST['course_id'];
    $topic_id = $_POST['topic_id'];
    $title = $_POST['exam_title'];
    $date = $_POST['exam_date'];
    $marks = $_POST['marks'];
    $type = $_POST['exam_type'];

    $sql = "INSERT INTO exam
            (course_id, topic_id, title, exam_date, total_marks, exam_type)
            VALUES
            ('$course_id', '$topic_id', '$title', '$date', '$marks', '$type')";

    if($conn->query($sql)){
        echo "<script>alert('Exam Created Successfully');</script>";
    }else{
        echo "Error: " . $conn->error;
    }
}

$courses = $conn->query("
SELECT course_id, course_name
FROM course
WHERE instructor_id = '$instructor_id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Exam</title>

<style>
body{margin:0;font-family:Segoe UI;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white}
.header{text-align:center;padding:20px;font-size:28px;font-weight:bold}
.container{max-width:500px;margin:auto;padding:20px}
input, select{width:100%;padding:12px;margin:10px 0;border:none;border-radius:8px;font-size:16px}
button{width:100%;padding:12px;background:#4facfe;border:none;border-radius:8px;color:white;font-size:18px;cursor:pointer}
</style>
</head>

<body>

<div class="header">📝 Create Exam</div>

<div class="container">

<form method="POST">

    <select name="course_id" required>
        <option value="">Select Course</option>

        <?php while($course = $courses->fetch_assoc()){ ?>
            <option value="<?php echo $course['course_id']; ?>">
                <?php echo $course['course_name']; ?>
            </option>
        <?php } ?>
    </select>

    <input type="number" name="topic_id" placeholder="Topic ID" required>

    <input type="text" name="exam_title" placeholder="Exam Title" required>

    <input type="date" name="exam_date" required>

    <input type="number" name="marks" placeholder="Marks" min="0" max="100" required>

    <select name="exam_type" required>
        <option value="">Select Exam Type</option>
        <option value="Quiz">Quiz</option>
        <option value="Midterm">Midterm</option>
        <option value="Final">Final</option>
    </select>

    <button type="submit" name="create">Create</button>

</form>

</div>

</body>
</html>