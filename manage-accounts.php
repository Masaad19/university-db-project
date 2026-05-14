<?php
$conn = new mysqli("localhost", "root", "", "university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

/* DELETE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $delete = "DELETE FROM login WHERE login_id = '$id'";
    $conn->query($delete);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

/* UPDATE */
if (isset($_POST['update'])) {
    $id = $_POST['login_id'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $update = "UPDATE login
               SET phone = '$phone',
                   role = '$role'
               WHERE login_id = '$id'";

    $conn->query($update);

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT login_id, phone, role FROM login";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Accounts</title>

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

input, select{
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

<div class="header">💻 Manage Accounts</div>

<div class="container">

<?php
if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
?>

<div class="card">

<form method="POST">

    <p><b>Login ID:</b> <?php echo $row['login_id']; ?></p>

    <input type="hidden" name="login_id" value="<?php echo $row['login_id']; ?>">

    <label>Phone</label>
    <input type="text" name="phone" value="<?php echo $row['phone']; ?>">

    <label>Role</label>
    <select name="role">
        <option value="student" <?php if($row['role']=="student") echo "selected"; ?>>student</option>
        <option value="instructor" <?php if($row['role']=="instructor") echo "selected"; ?>>instructor</option>
        <option value="admin" <?php if($row['role']=="admin") echo "selected"; ?>>admin</option>
    </select>

    <button type="submit" name="update">Edit</button>

    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?delete=<?php echo $row['login_id']; ?>"
       onclick="return confirm('Delete this account?');">
        <button type="button" class="delete">Delete</button>
    </a>

</form>

</div>

<?php
    }

}else{
    echo "<p>No accounts found.</p>";
}
?>

</div>

</body>
</html>