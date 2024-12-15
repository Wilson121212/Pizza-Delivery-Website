<?php
session_start();
include "dbconnect.php";
// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Initialize a variable to track success messages
$successMessage = '';

// Check if orderID is already set in the session
if (!isset($_SESSION['orderID'])) {
    // Fetch the last orderID from the database for a new entry
    $result = $db->query("SELECT IFNULL(MAX(orderID), 0) AS last_order_id FROM Orders");
    $row = $result->fetch_assoc();
    $_SESSION['orderID'] = $row['last_order_id'] + 1; // Store new orderID in session
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newOrderID = $_SESSION['orderID']; // Use orderID from session

    if (isset($_POST['addOrder19'])) {

        // Insert into the database
        $stmt = $db->prepare("INSERT INTO Orders (orderID, itemID, quantity) VALUES (?, ?, ?)");
        $itemID = 19; 
        $quantity = 1; 
        $stmt->bind_param("iii", $newOrderID, $itemID, $quantity);
        if ($stmt->execute()) {
            $successMessage = "1 x Promotion set has been successfully added.";
        } else {
            $successMessage = "Error inserting order ID 19: " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST['addOrder16'])) {

        // Insert into the database
        $stmt = $db->prepare("INSERT INTO Orders (orderID, itemID, quantity) VALUES (?, ?, ?)");
        $itemID = 16; 
        $quantity = 2; 
        $stmt->bind_param("iii", $newOrderID, $itemID, $quantity);
        if ($stmt->execute()) {
            $successMessage = "2 x Shroomza Pizza have been successfully added.";
        } else {
            $successMessage = "Error inserting order ID 16: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PengYu's Pizzas</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Uncial+Antiqua&display=swap" rel="stylesheet">
    <script>
        // Show an alert if there is a success message
        <?php if ($successMessage): ?>
        window.onload = function() {
            alert("<?php echo $successMessage; ?>");
        };
        <?php endif; ?>
    </script>
</head>

<body>
    <!-- Header Section -->
    <header>
    <nav class="nav-left">
            <a href="MainPage.php" class="active-page">Home</a>
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

    <!-- Main Banner Section -->
    <section class="banner">
        <img src="Main Page Pizza.png" alt="Pizza Banner">
    </section>

    <!-- Category Section -->
    <div class="nav-icons">
        <a href="Menupizza.html"><img src="Catpizza.png" alt="Pizza"> <h2>Pizza</h2></a>
        <a href="PersonalizedPizzaPage.php"><img src="Catcustom.png" alt="Custom Pizza"> <h2>Personalized Pizza</h2></a>
        <a href="Menumeal.php"><img src="Catmeal.png" alt="Set Meal"> <h2>Set Meal</h2></a>
        <a href="Menuside.html"><img src="Catside.png" alt="Sides"> <h2>Sides</h2></a>
        <a href="Menudrinks.html"><img src="Catdrinks.png" alt="Drinks"> <h2>Drinks</h2></a>
    </div>

    <!-- Seasonal Promotion Section -->
    <section class="seasonal-promotion">
        <h3>SEASONAL PROMOTION</h3>
        <h4>Don't Miss Out Our Top Deals</h4>
        <table border="1"> 
            <tr>
                <td rowspan="2" class="left_table"> 
                    <div class="floatleft">
                        <img src="Main Page Promo 1.png" alt="Promotion 1" width="320" height="auto">
                    </div>
                    <div class="floatright">
                        
                        <p><strong><em>Promotion Set:</strong></em><br><br>3x Margherita Pizza <br>(12-in., thin-crust)<br> 2x Garlic Bread
                            <br> 4x Chicken Wings<br> 1x Himalayan Fries<br> 3x Coca-Cola</p>
                        <img src="Promoprice.png" alt="Now Only $49.99" height="120" width="auto" class="floatleft2"><br><br><br>
                        <form method="post">
                        <button type="submit" name="addOrder19">Add Now</button>
                        </form>
                    </div>
                </td>
                <td class="right_table1">
                    <div class="floatleft">
                        <img src="Main Page Promo 2.png" alt="Promotion 2" height="170px" width="auto">
                    </div>
                    <div class="floatright">
                        <img src="Promo2img.png" alt="Buy1Free1" height="70px" width="auto" class="floatright2">
                        <p id="Promo2words">Shroomzza Pizza <br>(9-inch, Cheese-crust)</p>
                        <form method="post">
                        <button type="submit" class="floatright2" name="addOrder16">Add Now</button>
                        </form>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="right_table2">
                    <div class="floatleft">
                        <img src="Main Page Promo 3.png" alt="Delivery Rider" 
                        class="delivery-driver" height="140px" width="220">
                    </div>
                    <div class="floatright">
                        <img src="Promo3.png" alt="Delivery Rider" 
                        class="deliverySlogan" height="150px" width="220">
                    </div>
                </td>
            </tr>
        </table>
    </section>

    <!-- Our Signature Section -->
    <section class="signature">
        <h3>OUR SIGNATURE</h3>
        <h4>Popular Dishes</h4>
        <div class="signature-container">
            <div class="signature-item" onclick="window.location.href='MargheritaPizza.php';" style="cursor: pointer;">
                <h5>Margherita Pizza</h5>
                <img src="Main Page Signature 1.jpg" alt="Margherita Pizza">
                <p>4.5 ⭐ (260 reviews)</p>
                <p>$17.90</p>
            </div>
            <div class="signature-item" onclick="window.location.href='PepperoniPizza.php';" style="cursor: pointer;">
                <h5>Pepperoni Pizza</h5>
                <img src="Main Page Signature 2.jpg" alt="Pepperoni Pizza">
                <p>4.9 ⭐ (204 reviews)</p>
                <p>$15.90</p>
            </div>
            <div class="signature-item" onclick="window.location.href='HimalayanFries.php';" style="cursor: pointer;">
                <h5>Himalayan Fries</h5>
                <img src="HimalayanFries.jpg" alt="Himalayan Salt Fries">
                <p>4.6 ⭐ (193 reviews)</p>
                <p>$5.90</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>Co-founder: Peng Teng Kang & Yu Liguang<p>
        <strong><a href="logout.php" style="color: white; text-decoration: underline; font: inherit;">Log out </a></strong>
        <p> PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>
