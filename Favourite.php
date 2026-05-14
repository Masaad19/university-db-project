<?php
session_start();

$conn = new mysqli("localhost","root","","university_academic_support_system");

if ($conn->connect_error) {
    die("Connection failed");
}

if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$sql = "SELECT f.favorite_id, f.student_id, f.saved_date,
               sm.title, sm.description
        FROM favourite f
        JOIN support_material sm
        ON f.support_material_id = sm.support_material_id
        WHERE f.student_id = $student_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Favorites</title>

<style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    color: white;
}

.header {
    text-align: center;
    padding: 20px;
    font-size: 28px;
    font-weight: bold;
}

.container {
    padding: 20px;
}

.card {
    background: rgba(255,255,255,0.08);
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 15px;
}
</style>
</head>

<body>

<div class="header">⭐ Favorites</div>

<div class="container">

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "
        <div class='card'>
            <p><b>Favorite ID:</b> {$row['favorite_id']}</p>
            <p><b>Student ID:</b> {$row['student_id']}</p>
            <p><b>Title:</b> {$row['title']}</p>
            <p><b>Description:</b> {$row['description']}</p>
            <p><b>Saved Date:</b> {$row['saved_date']}</p>
        </div>
        ";
    }
} else {
    echo "<p>No favorites yet ⭐</p>";
}
?>

</div>

</body>
</html>