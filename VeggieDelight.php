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

    if (isset($_POST['addVeggie'])) {
        // Determine itemID based on selected size
        $size = $_POST['Veggiesize'];
        $thickness = $_POST['Veggiethickness'];
        $sauce = $_POST['Veggiesauce'];
        $quantity = isset($_POST['VeggieQty']) ? (int)$_POST['VeggieQty'] : 0;

        // Set itemID based on size
        $itemID = 0; // Default to 0
        switch ($size) {
            case 'small':
                $itemID = 7; // Small
                break;
            case 'medium':
                $itemID = 8; // Medium
                break;
            case 'large':
                $itemID = 9; // Large
                break;
        }

        // Add order to the cart and the database if quantity is greater than 0
        if ($quantity > 0) {
           
            // Insert into the database
            $stmt = $db->prepare("INSERT INTO Orders (orderID, itemID, quantity, thickness, sauce) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("iiiss", $newOrderID, $itemID, $quantity, $thickness, $sauce);
            if ($stmt->execute()) {
                $successMessage = "$quantity x Veggie Delight Pizza (Size: $size, Thickness: $thickness, Sauce: $sauce) has been successfully added.";
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
    <title>Margherita Pizza - PengYu's Pizzas</title>
    <link rel="stylesheet" href="stylesmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        // Show an alert if there is a success message
        <?php if ($successMessage): ?>
        window.onload = function() {
            alert("<?php echo $successMessage; ?>");
            // Redirect to MenuPizza.html after the alert is dismissed
            window.location.href = 'MenuPizza.html';
        };
        <?php endif; ?>
    </script>
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

    <!-- Main Banner Section -->
    <section class="banner">
        <img src="Product Banner.png" alt="Menu Banner">
    </section>

    <!-- Menu Section -->
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
        <div class="pizza-detail">
            <img src="Veggie Pizza.webp" alt="Veggie Delight">
            <h2>Veggie Delight</h2>
            <p>Our Veggie Delight is a vibrant feast for the eyes and the palate, featuring a colorful medley of bell peppers, sweet onions, succulent mushrooms, black olives, and a sprinkle of diced tomatoes.</p>
            <p>4.4 ⭐ (143)</p>
            <p>$15.90</p>
        </div>      

         <!-- Customization Form -->
    <form id="customizeForm" method="post">
        <label for="sauce">Choose a sauce:</label>
        <select id="sauce" name="Veggiesauce">
            <option value="tomato">Tomato</option>
            <option value="pesto">Pesto</option>
            <option value="white_garlic">White Garlic</option>
        </select>

        <label for="thickness">Choose the crust thickness:</label>
        <select id="thickness" name="Veggiethickness">
            <option value="thin">Thin</option>
            <option value="regular">Regular</option>
            <option value="thick">Thick</option>
        </select>

        <label for="size">Choose the size:</label>
        <select id="size" name="Veggiesize">
            <option value="small">Small - 10"</option>
            <option value="medium">Medium - 12"</option>
            <option value="large">Large - 14"</option>
        </select>

        <label for="VeggieQty">Quantity:</label>
        <input type="number" min="0" id="VeggieQty" 
        name="VeggieQty" value="0" >

        <button type="submit" class="add-to-cart-button" name="addVeggie">Add to Cart</button>
    </form>
    </main>
    </section>

    <!-- Footer -->
    <footer>
        <p>Co-founder: Peng Teng Kang & Yu Liguang<p>
        <p> PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>
