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

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$message = "";

/* TOGGLE FAVORITE - STUDENT ONLY */
if (isset($_POST['toggle_favorite']) && $_SESSION['role'] == 'student') {

    $student_id = $_SESSION['student_id'];
    $support_material_id = intval($_POST['support_material_id']);

    $check_sql = "
        SELECT favorite_id
        FROM favourite
        WHERE student_id = ?
        AND support_material_id = ?
    ";

    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("ii", $student_id, $support_material_id);
    $stmt->execute();
    $check_result = $stmt->get_result();

    if ($check_result->num_rows > 0) {

        $delete_sql = "
            DELETE FROM favourite
            WHERE student_id = ?
            AND support_material_id = ?
        ";

        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("ii", $student_id, $support_material_id);
        $stmt->execute();

        $message = "Removed from Favorites 🤍";

    } else {

        $insert_sql = "
            INSERT INTO favourite
            (student_id, support_material_id, saved_date)
            VALUES
            (?, ?, CURDATE())
        ";

        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ii", $student_id, $support_material_id);
        $stmt->execute();

        $message = "Added to Favorites ⭐";
    }
}

/* GET FAVORITES FOR CURRENT STUDENT */
$favorites = [];

if ($_SESSION['role'] == 'student') {

    $student_id = $_SESSION['student_id'];

    $fav_sql = "
        SELECT support_material_id
        FROM favourite
        WHERE student_id = ?
    ";

    $stmt = $conn->prepare($fav_sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $fav_result = $stmt->get_result();

    while ($fav = $fav_result->fetch_assoc()) {
        $favorites[] = $fav['support_material_id'];
    }
}

/* FILTER SUPPORT MATERIALS BASED ON ROLE */
if ($_SESSION['role'] == 'student') {

    $student_id = $_SESSION['student_id'];

    $sql = "
        SELECT DISTINCT
            sm.support_material_id,
            sm.course_id,
            sm.title,
            sm.description,
            sm.file_link
        FROM enrollment e
        INNER JOIN support_material sm
        ON e.course_id = sm.course_id
        WHERE e.student_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

} else {

    $instructor_id = $_SESSION['instructor_id'];

    $sql = "
        SELECT DISTINCT
            sm.support_material_id,
            sm.course_id,
            sm.title,
            sm.description,
            sm.file_link
        FROM support_material sm
        INNER JOIN course c
        ON sm.course_id = c.course_id
        WHERE c.instructor_id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $instructor_id);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>Support Materials</title>

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
    margin-bottom:15px;
}

.pdf-btn{
    margin-top:10px;
    padding:8px 15px;
    border:none;
    border-radius:8px;
    background:#4facfe;
    color:white;
    font-weight:bold;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
}

.fav-btn{
    margin-top:10px;
    margin-left:8px;
    width:45px;
    height:45px;
    border:none;
    border-radius:50%;
    background:white;
    font-size:22px;
    cursor:pointer;
}
</style>
</head>

<body>

<div class="header">🧾 Support Materials</div>

<div class="container">

<?php
if($message != ""){
    echo "<div class='message'>" . htmlspecialchars($message) . "</div>";
}

if($result->num_rows > 0){

    while($row = $result->fetch_assoc()){

        $is_favorite = in_array($row['support_material_id'], $favorites);

        echo "
        <div class='card'>
            <p><b>ID:</b> " . htmlspecialchars($row['support_material_id']) . "</p>
            <p><b>Course ID:</b> " . htmlspecialchars($row['course_id']) . "</p>
            <p><b>Title:</b> " . htmlspecialchars($row['title']) . "</p>
            <p><b>Description:</b> " . htmlspecialchars($row['description']) . "</p>
        ";

        if(!empty($row['file_link'])){
            echo "<a class='pdf-btn' href='" . htmlspecialchars($row['file_link']) . "' target='_blank'>Open PDF</a>";
        }

        if($_SESSION['role'] == 'student'){
            echo "
            <form method='POST' style='display:inline;'>
                <input type='hidden' name='support_material_id' value='" . htmlspecialchars($row['support_material_id']) . "'>
                <button type='submit' name='toggle_favorite' class='fav-btn'>
                    " . ($is_favorite ? "⭐" : "🤍") . "
                </button>
            </form>
            ";
        }

        echo "</div>";
    }

}else{
    echo "<p>No support materials found.</p>";
}
?>

</div>

</body>
</html>