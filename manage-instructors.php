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
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $delete = "DELETE FROM instructor 
               WHERE instructor_id='$id'";

    $conn->query($delete);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


/* UPDATE */
if (isset($_POST['update'])) {

    $id = $_POST['instructor_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    $update = "UPDATE instructor 
               SET name='$name',
                   email='$email'
               WHERE instructor_id='$id'";

    $conn->query($update);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


$sql = "SELECT instructor_id, name, email FROM instructor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Manage Instructors</title>

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
    👨‍🏫 Manage Instructors
</div>

<div class="container">

<?php

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

?>

<div class="card">

<form method="POST">

    <p>
        <b>Instructor ID:</b>
        <?php echo $row['instructor_id']; ?>
    </p>

    <input
        type="hidden"
        name="instructor_id"
        value="<?php echo $row['instructor_id']; ?>"
    >

    <label>Name</label>

    <input
        type="text"
        name="name"
        value="<?php echo $row['name']; ?>"
    >

    <label>Email</label>

    <input
        type="email"
        name="email"
        value="<?php echo $row['email']; ?>"
    >

    <button type="submit" name="update">
        Edit
    </button>

    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete=<?php echo $row['instructor_id']; ?>"
       onclick="return confirm('Delete this instructor?');">

        <button type="button" class="delete">
            Delete
        </button>

    </a>

</form>

</div>

<?php

    }

} else {

    echo "<p>No instructors found.</p>";
}

?>

</div>

</body>
</html>