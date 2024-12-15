<?php
session_start();
include "dbconnect.php";
ini_set('display_errors', 1);
error_reporting(E_ALL);

$successMessage = '';

if (!isset($_SESSION['orderID'])) {
    $result = $db->query("SELECT IFNULL(MAX(orderID), 0) AS last_order_id FROM Orders");
    $row = $result->fetch_assoc();
    $_SESSION['orderID'] = $row['last_order_id'] + 1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newOrderID = $_SESSION['orderID'];

    if (isset($_POST['addIcedLemonTea'])) {
        $quantity = isset($_POST['IcedLemonTeaQty']) ? (int)$_POST['IcedLemonTeaQty'] : 0;
        $itemID = 30;

        if ($quantity > 0) {
            $stmt = $db->prepare("INSERT INTO Orders (orderID, itemID, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $newOrderID, $itemID, $quantity);
            if ($stmt->execute()) {
                $successMessage = "$quantity x Iced Lemon Tea has been successfully added.";
            } else {
                $successMessage = "Error inserting order: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $successMessage = "Please select a quantity greater than 0.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iced Lemon Tea - PengYu's Pizzas</title>
    <link rel="stylesheet" href="stylesmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        <?php if ($successMessage): ?>
        window.onload = function() {
            alert("<?php echo $successMessage; ?>");
            window.location.href = 'MenuPizza.html';
        };
        <?php endif; ?>
    </script>
</head>
<body>
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
            <a href="#track-order">Track Order</a>
            <a href="cart.php"><img src="cart-icon.png" alt="Cart" class="logo-img" width="30" height="25"></a>
        </nav>
    </header>

    <section class="banner">
        <img src="Product Banner.png" alt="Menu Banner">
    </section>

    <section class="menu">
        <div class="categories">
            <h3>Categories</h3>
            <ul>
                <li>
                    <a href="Menupizza.html">
                        <img src="Menupizza.png" alt="Pizza">
                        <span>Pizza</span>
                    </a>
                </li>
                <li>
                    <a href="PersonalizedPizzaPage.php">
                        <img src="Menucustom.png" alt="Custom Pizza">
                        <span>Personalized Pizza</span>
                    </a>
                </li>
                <li>
                    <a href="Menumeal.php">
                        <img src="Menumeal.png" alt="Set Meal">
                        <span>Set Meal</span>
                    </a>
                </li>
                <li>
                    <a href="Menuside.html">
                        <img src="Menuside.png" alt="Sides">
                        <span>Sides</span>
                    </a>
                </li>
                <li>
                    <a href="Menudrinks.html">
                        <img src="Menudrinks.png" alt="Drinks">
                        <span>Drinks</span>
                    </a>
                </li>
            </ul>
        </div>

        <main>
        <div class="pizza-container">
        <div class="pizza-detail">
                <img src="Iced Lemon Tea.jpg" alt="Iced Lemon Tea">
                <h2>Iced Lemon Tea</h2>
                <p>Chilled Iced Lemon Tea, perfectly sweetened and refreshing.</p>
                <p>4.9 ⭐ (310)</p>
                <p>$3.00</p>
            </div>

            <form method="post" id="customizeForm1" class="grey-box">
                <label for="IcedLemonTeaQty">Quantity:</label>
                <input type="number" min="0" id="IcedLemonTeaQty" name="IcedLemonTeaQty" value="0">
                <button type="submit" class="add-to-cart-button" name="addIcedLemonTea">Add to Cart</button>
            </form>
        </main>
    </section>

    <footer>
        <p>Co-founder: Peng Teng Kang & Yu Liguang</p>
        <p>PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>
