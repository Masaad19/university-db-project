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

$message = "";

/* Delete Department */
if(isset($_POST['delete'])){
    $dep_id = $_POST['dep_id'];

    $delete = "DELETE FROM department WHERE dep_id = $dep_id";

    if($conn->query($delete)){
        $message = "Department deleted successfully.";
    }else{
        $message = "Cannot delete this department because it is linked to other data.";
    }
}

/* Update Department */
if(isset($_POST['update'])){
    $dep_id = $_POST['dep_id'];
    $dep_name = $_POST['dep_name'];

    $update = "UPDATE department SET dep_name = '$dep_name' WHERE dep_id = $dep_id";

    if($conn->query($update)){
        $message = "Department updated successfully.";
    }
}

$sql = "SELECT dep_id, dep_name FROM department ORDER BY dep_id ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Departments</title>

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

.message{
    background:rgba(255,255,255,0.15);
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
    font-weight:bold;
}

.card{
    background:rgba(255,255,255,0.1);
    padding:15px;
    border-radius:10px;
    margin-bottom:10px;
}

input{
    padding:8px;
    border:none;
    border-radius:8px;
    margin:5px 0;
    width:250px;
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

.delete-btn{
    background:#ff4d4d;
}
</style>
</head>

<body>

<div class="header">🏛 Manage Departments</div>

<div class="container">

<?php
if($message != ""){
    echo "<div class='message'>$message</div>";
}

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        echo "
        <div class='card'>

            <p><b>Department ID:</b> {$row['dep_id']}</p>

            <form method='POST'>
                <input type='hidden' name='dep_id' value='{$row['dep_id']}'>
                <p><b>Department Name:</b></p>
                <input type='text' name='dep_name' value='{$row['dep_name']}' required>

                <br>

                <button type='submit' name='update'>Edit</button>
                <button type='submit' name='delete' class='delete-btn'>Delete</button>
            </form>

        </div>
        ";
    }

}else{
    echo '<p>No departments found.</p>';
}
?>

</div>

</body>
</html>