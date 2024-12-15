<?php
session_start();
$old_user = $_SESSION['valid_user'];  
unset($_SESSION['valid_user']);
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Out - PengYu's Pizza</title>
    <style>
        body {
            background-color: #455835;
            color: black;
        }
        .logout-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .logout-box {
            background: #e4efde;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h1 {
            color: black;
            font-family: Serif, Garamond;
            margin-bottom: 20px;
        }
        a {
            color: black;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="logout-container">
    <div class="logout-box">
        <h1>Log Out</h1>
        <?php 
        if (!empty($old_user)) {
            echo 'Logged out.<br />';
        } else {
            echo 'You were not logged in, and so have not been logged out.<br />'; 
        }
        ?> 
        <a href="LoginPage.php">Back to Login Page</a>
    </div>
</div>
</body>
</html>
