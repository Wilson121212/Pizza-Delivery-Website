<?php
include "dbconnect.php";

if (isset($_POST['submit'])) {
    // Check if fields are empty
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password2'])) {
        echo "<script>
                alert('All fields must be filled in.');
                window.location.href = 'Registration.html';
              </script>";
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

      // Validate password length and format
      if (!preg_match('/^(?=.*[A-Z])[A-Za-z\d]{6,12}$/', $password)) {
        echo "<script>
                alert('Password must be 6-12 characters long and include at least one uppercase letter.');
                window.location.href = 'Registration.html';
              </script>";
        exit;
    }

    // Check if passwords match
    if ($password != $password2) {
        echo "<script>
                alert('Sorry, passwords do not match.');
                window.location.href = 'Registration.html';
              </script>";
        exit;
    }

    // Check if username already exists
    $checkUserQuery = "SELECT * FROM user1 WHERE username = '$username'";
    $checkUserResult = $db->query($checkUserQuery);

    if ($checkUserResult->num_rows > 0) {
        echo "<script>
                alert('Username already exists. Please choose a different username.');
                window.location.href = 'Registration.html';
              </script>";
        exit;
    }

    // Hash the password
    $password = md5($password);

    // Insert into the database
    $sql = "INSERT INTO user1 (username, password) VALUES ('$username', '$password')";
    $result = $db->query($sql);

    if (!$result) {
        echo "<script>
                alert('Your query failed. Please try again.');
                window.location.href = 'Registration.html';
              </script>";
    } else {
        echo "<script>
                alert('Welcome $username. You are now registered.');
                window.location.href = 'LoginPage.php';
              </script>";
    }
}
?>
