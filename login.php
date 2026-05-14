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

$error = "";

if(isset($_POST['login'])){

    $login_id = $_POST['username'];
    $password = $_POST['password'];

    $sql = "
    SELECT
        l.login_id,
        l.password,
        l.role,

        s.student_id,

        i.instructor_id

    FROM login l

    LEFT JOIN student s
    ON l.login_id = s.login_id

    LEFT JOIN instructor i
    ON l.login_id = i.login_id

    WHERE l.login_id = ?
    ";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $login_id);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        if($password == $row['password']){

            $_SESSION['login_id'] = $row['login_id'];

            $_SESSION['role'] = $row['role'];

            /* STUDENT */

            if($row['role'] == 'student'){

                $_SESSION['student_id'] = $row['student_id'];

                header("Location: student.html");

                exit();
            }

            /* INSTRUCTOR */

            elseif($row['role'] == 'instructor'){

                $_SESSION['instructor_id'] = $row['instructor_id'];

                header("Location: instructor.html");

                exit();
            }

            /* ADMIN */

            elseif($row['role'] == 'admin'){

                header("Location: admin.html");

                exit();
            }

        }else{

            $error = "Wrong Password";
        }

    }else{

        $error = "Invalid Login ID";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>UASS - Login</title>

<link rel="stylesheet" href="login.css">

</head>

<body>

<header class="header">

   <div class="logo">

    <div class="logo-svg">

        <svg width="70" height="70" viewBox="0 0 240 240" xmlns="http://www.w3.org/2000/svg">

            <defs>
                <linearGradient id="bgGradient" x1="0" y1="0" x2="1" y2="1">
                    <stop offset="0%" stop-color="#6c63ff"/>
                    <stop offset="100%" stop-color="#3a3a8f"/>
                </linearGradient>

                <filter id="glow">
                    <feGaussianBlur stdDeviation="4" result="coloredBlur"/>
                    <feMerge>
                        <feMergeNode in="coloredBlur"/>
                        <feMergeNode in="SourceGraphic"/>
                    </feMerge>
                </filter>
            </defs>

            <circle cx="120" cy="120" r="100" fill="url(#bgGradient)"/>

            <circle
                cx="120"
                cy="120"
                r="90"
                stroke="white"
                stroke-opacity="0.2"
                stroke-width="2"
                fill="none"
            />

            <g filter="url(#glow)">
                <polygon points="70,100 120,70 170,100 120,130" fill="white"/>
                <rect x="95" y="130" width="50" height="8" fill="white"/>
            </g>

            <line x1="80" y1="150" x2="160" y2="150" stroke="white" stroke-opacity="0.3"/>
            <line x1="90" y1="160" x2="150" y2="160" stroke="white" stroke-opacity="0.2"/>

            <text
                x="50%"
                y="200"
                text-anchor="middle"
                fill="white"
                font-size="16"
                font-family="Segoe UI, Arial"
            >
                UASS
            </text>

        </svg>

    </div>

    <span>UASS</span>

</div>

</header>

<hr>

<div class="container">

    <div class="box">

        <h2>Login</h2>

        <?php

        if($error != ""){

            echo "
            <p style='color:red; text-align:center;'>
                $error
            </p>
            ";
        }

        ?>

        <form method="POST">

            <div class="inputBox">

                <label>Login ID</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter Login ID"
                    required
                >

            </div>

            <div class="inputBox">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter Password"
                    required
                >

            </div>

            <div class="inputBox">

                <button type="submit" name="login">

                    Sign In

                </button>

            </div>

        </form>

    </div>

</div>

</body>

</html>