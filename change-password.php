<?php
session_start();

$conn = new mysqli("localhost", "root", "", "university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

if (!isset($_SESSION['login_id'])) {
    header("Location: login.php");
    exit();
}

$login_id = $_SESSION['login_id'];
$message = "";

if (isset($_POST['change_password'])) {

    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    $sql = "SELECT password FROM login WHERE login_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $login_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $row = $result->fetch_assoc();

    if ($current_password != $row['password']) {
        $message = "Current password is incorrect.";
    } elseif ($new_password != $confirm_password) {
        $message = "Passwords do not match.";
    } elseif (strlen($new_password) < 8) {
        $message = "Password must be at least 8 characters.";
    } elseif (!preg_match('/[A-Za-z]/', $new_password)) {
        $message = "Password must contain letters.";
    } elseif (!preg_match('/[0-9]/', $new_password)) {
        $message = "Password must contain numbers.";
    } elseif (!preg_match('/[^A-Za-z0-9]/', $new_password)) {
        $message = "Password must contain a special character.";
    } else {
        $update_sql = "UPDATE login SET password = ? WHERE login_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_password, $login_id);

        if ($update_stmt->execute()) {
            $message = "Password changed successfully ✅";
        } else {
            $message = "Error updating password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Change Password</title>

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
    max-width:500px;
    margin:auto;
    padding:20px;
}

.card{
    background:rgba(255,255,255,0.1);
    padding:25px;
    border-radius:15px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border:none;
    border-radius:10px;
    box-sizing:border-box;
    font-size:15px;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:10px;
    background:#4facfe;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#00c6ff;
}

.message{
    background:rgba(255,255,255,0.15);
    padding:12px;
    border-radius:10px;
    margin-bottom:15px;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="header">
🔐 Change Password
</div>

<div class="container">
<div class="card">

<p><b>Current Login ID:</b> <?php echo htmlspecialchars($login_id); ?></p>

<?php
if ($message != "") {
    echo "<div class='message'>" . htmlspecialchars($message) . "</div>";
}
?>

<form method="POST">

<input type="password" name="current_password" placeholder="Current Password" required>

<input type="password" name="new_password" placeholder="New Password" required>

<input type="password" name="confirm_password" placeholder="Confirm New Password" required>

<button type="submit" name="change_password">
Change Password
</button>

</form>

</div>
</div>

</body>
</html>