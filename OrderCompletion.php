<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PengYu's Pizzas</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Uncial+Antiqua&display=swap" rel="stylesheet">

<style>
    html, body {
            height: 100%;
            
    }
    .Notes {
        background-color: #e4efde;
        padding: 50px; /* Add padding for spacing */
        height: calc(100% - 100px); /* Adjust height to fit the viewport */
        display: flex; /* Use flexbox for alignment */
        flex-direction: column; /* Align items in a column */
    }
    .track-button {
        display: block;
        width: 50%;
        margin: 30px auto;
        background-color: #9eeca0;
        color: #02542D;
        font-size: 16px;
        padding: 10px;
        border-radius: 25px;
        cursor: pointer;
    }

    .track-button:hover {
        background-color: #569e49;
    }
    h5{
        font-family: Didot, serif;
        font-size: 30px;
        display: flex;
        align-items: center;
        justify-content: start;
        margin-bottom: 20px;
    }
   
</style>
</head>
<body>
    <!-- Header Section -->
    <header>
    <nav class="nav-left">
        <a href="MainPage.php">Home</a>
        <a href="MenuPizza.html">Menu</a>
        <a href="PersonalizedPizzaPage.php">Personalized Pizza</a>
    </nav>
    <div class="logo">
        <img src="Logo.png" alt="PengYu's Pizza Logo" width="50">
        <h1>PengYu's Pizza</h1>
    </div>
    <nav class="nav-right">
        <a href="AboutUs.html">About Us</a>
        <a href="FeedbackPage.php">Reviews</a>
        <a href="trackorder.php">Track Order</a>
        <a href="cart.php"><img src="cart-icon.png" alt="Cart" class="logo-img" width="30" height="25"></a>
        </nav>
    </header>

    <section class="Notes">
    <div>
        <h5>YOUR ORDER HAS BEEN SUBMITTED! <br>THANK YOU!</h5>
    </div>
    <div>
    <?php
        // Start session
        session_start();
        include "dbconnect.php";
        if (!isset($_SESSION['orderID'])) {
            echo "<p>No active orders found.</p>";
            exit;
        }
        if (isset($_POST['Payment'])) {
            $_SESSION['paymentMethod'] = $_POST['Payment'];
            //echo "Payment method stored: " . $_SESSION['paymentMethod'];
        } else {
            echo "Payment method not set.";
        }
        $newOrderID = $_SESSION['orderID'];
        echo "<h4><br><br>Your Order Number is $newOrderID.<br><br><br></h4>";
        echo "<p>Please track the delivery progress using the button below.  
            Enjoy PengYu's Pizza!</p>
            <p style='font-size:small;'>***If you wish to make another order, 
            please log out the session. Thank you!<br><br><br></p>";
    ?>
    
    <a href="trackorder.php">
        <button type="submit" class="track-button" name="trackorder">Track Your Order</a>
    </div>
    </section>

    <footer>
        <p>Co-founders: Peng Teng Kang & Yu Liguang</p>
        <p>PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>
