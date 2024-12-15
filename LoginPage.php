<?php 
include "dbconnect.php";
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['userid']) && isset($_POST['password'])) {
    
    $userid = $_POST['userid'];
    $password = $_POST['password'];

    // Hash the password
    $password = md5($password);

    $query = "SELECT * FROM user1 WHERE BINARY username='$userid' AND BINARY password='$password'";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        // Login successfully
        $_SESSION['valid_user'] = $userid;   
        // Redirect to Mainpage.php
        header("Location: MainPage.php");
        exit(); 
    } else {
        echo "<p style='color:red; text-align:center;'>Incorrect username or password.</p>";
    }
    $db->close();
}
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - PengYu's Pizza</title>
  <style>
      body {
          background-color: #455835;
          color: black; 
      }
      .login-container {
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100vh; 
      }
      .login-box {
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
      input[type="text"], input[type="password"] {
          width: 100%;
          padding: 10px;
          margin: 5px 0 20px;
          border: 1px solid #ddd;
          border-radius: 4px;
          box-sizing: border-box; 
      }
      input[type="submit"] {
          background-color: #c0392b; 
          color: white;
          border: none;
          padding: 10px;
          border-radius: 4px;
          cursor: pointer;
          width: 100%;
          font-size: 16px;
      }
      input[type="submit"]:hover {
          background-color: #e74c3c; 
      }
      .register-link {
          margin-top: 20px; 
          color: black; 
          text-decoration: none; 
      }
      .register-link:hover {
          text-decoration: underline; 
      }
  </style>
</head>
<body>
<div class="login-container">
  <div class="login-box">
    <h1>Log In</h1>
    <?php
      if (isset($_SESSION['valid_user'])) {
        echo 'You are logged in as: '.$_SESSION['valid_user'].' <br />';
        echo '<a href="logout.php">Log out</a><br />';
      } 
      else {
          if (isset($userid)) {
              echo 'Could not log you in.<br><br />';
          } else {
              echo 'You are not logged in.<br><br />';
          }

          // Log in form 
          echo '<form method="post" action="loginpage.php">';
          echo '<label for="userid">User ID:</label>';
          echo '<small style="display:block; color:#888; margin-top:5px;">Note: User ID is case-sensitive.</small>';
          echo '<input type="text" name="userid" required>';
          echo '<label for="password">Password:</label>';
          echo '<input type="password" name="password" required>';
          echo '<input type="submit" value="Log in"><br /><br />';
          echo '<a href="registration.html" class="register-link">Create an account</a> ';
          echo '</form>';
      }
    ?>
  </div>
</div>
</body>
</html>
