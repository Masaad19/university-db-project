<?php
session_start();

$conn = new mysqli("localhost", "root", "", "university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

$instructor_id = $_SESSION['instructor_id'];

/* ADD MATERIAL */
if(isset($_POST['upload'])){

    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = date("Y-m-d");

    $insert = "INSERT INTO material(course_id, title, description, upload_date)
               VALUES('$course_id', '$title', '$description', '$date')";

    $conn->query($insert);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

/* DELETE MATERIAL */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $delete = "DELETE FROM material
               WHERE material_id='$id'";

    $conn->query($delete);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

/* GET INSTRUCTOR COURSES */
$courses = $conn->query("
SELECT course_id, course_name
FROM course
WHERE instructor_id = '$instructor_id'
");

/* GET MATERIALS FOR INSTRUCTOR COURSES ONLY */
$sql = "
SELECT 
    m.material_id,
    m.title,
    m.description,
    m.upload_date,
    c.course_name
FROM material m
JOIN course c
ON m.course_id = c.course_id
WHERE c.instructor_id = '$instructor_id'
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Upload Materials</title>

<style>
body{margin:0;font-family:Segoe UI;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white}
.header{text-align:center;padding:20px;font-size:28px;font-weight:bold}
.container{padding:20px}
.card{background:rgba(255,255,255,0.1);padding:15px;border-radius:10px;margin-bottom:15px}
input, textarea, select{width:100%;padding:10px;margin-top:5px;margin-bottom:10px;border:none;border-radius:8px}
button{margin-top:10px;padding:10px 15px;border:none;border-radius:8px;background:#4facfe;color:white;font-weight:bold;cursor:pointer}
.delete{background:#ff4d4d}
</style>
</head>

<body>

<div class="header">📂 Upload Materials</div>

<div class="container">

<div class="card">
<h2>Add New Material</h2>

<form method="POST">

    <label>Course</label>
    <select name="course_id" required>
        <option value="">Select Course</option>

        <?php while($course = $courses->fetch_assoc()){ ?>
            <option value="<?php echo $course['course_id']; ?>">
                <?php echo $course['course_name']; ?>
            </option>
        <?php } ?>

    </select>

    <label>Title</label>
    <input type="text" name="title" required>

    <label>Description</label>
    <textarea name="description" rows="4" required></textarea>

    <button type="submit" name="upload">Upload Material</button>

</form>
</div>

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
?>

<div class="card">

    <p><b>Material ID:</b> <?php echo $row['material_id']; ?></p>
    <p><b>Course:</b> <?php echo $row['course_name']; ?></p>
    <p><b>Title:</b> <?php echo $row['title']; ?></p>
    <p><b>Description:</b> <?php echo $row['description']; ?></p>
    <p><b>Upload Date:</b> <?php echo $row['upload_date']; ?></p>

    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete=<?php echo $row['material_id']; ?>"
       onclick="return confirm('Delete this material?');">
        <button type="button" class="delete">Delete</button>
    </a>

</div>

<?php
    }

}else{
    echo "<p>No materials found.</p>";
}
?>

</div>

</body>
</html>