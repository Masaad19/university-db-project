<?php
$conn = new mysqli(
    "localhost",
    "root",
    "",
    "university_academic_support_system"
);

if ($conn->connect_error) {
    die("Connection failed");
}


/* DELETE */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $delete = "DELETE FROM course
               WHERE course_id='$id'";

    $conn->query($delete);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


/* UPDATE */
if(isset($_POST['update'])){

    $id = $_POST['course_id'];
    $name = $_POST['course_name'];
    $hours = $_POST['credit_hours'];

    $update = "UPDATE course
               SET course_name='$name',
                   credit_hours='$hours'
               WHERE course_id='$id'";

    $conn->query($update);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


$sql = "SELECT course_id, course_name, credit_hours FROM course";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Courses</title>

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

input{
    width:100%;
    padding:10px;
    margin-top:5px;
    margin-bottom:10px;
    border:none;
    border-radius:8px;
}

button{
    padding:8px 15px;
    border:none;
    border-radius:8px;
    background:#4facfe;
    color:white;
    font-weight:bold;
    cursor:pointer;
    margin-right:5px;
}

.delete{
    background:#ff4d4d;
}

</style>

</head>

<body>

<div class="header">
    📚 Manage Courses
</div>

<div class="container">

<?php

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

?>

<div class="card">

<form method="POST">

    <p>
        <b>Course ID:</b>
        <?php echo $row['course_id']; ?>
    </p>

    <input
        type="hidden"
        name="course_id"
        value="<?php echo $row['course_id']; ?>"
    >

    <label>Course Name</label>

    <input
        type="text"
        name="course_name"
        value="<?php echo $row['course_name']; ?>"
    >

    <label>Credit Hours</label>

    <input
        type="number"
        name="credit_hours"
        value="<?php echo $row['credit_hours']; ?>"
    >

    <button type="submit" name="update">
        Edit
    </button>

    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete=<?php echo $row['course_id']; ?>"
       onclick="return confirm('Delete this course?');">

        <button type="button" class="delete">
            Delete
        </button>

    </a>

</form>

</div>

<?php

    }

}else{

    echo "<p>No courses found.</p>";
}

?>

</div>

</body>
</html>