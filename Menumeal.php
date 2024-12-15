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

    if (isset($_POST['addPizza'])) {
        // Get the pizza choice
        $pizzaChoice = $_POST['pizza-choice'];
        $quantity = isset($_POST['pizzaQty']) ? (int)$_POST['pizzaQty'] : 0;

        // Set itemID based on pizza choice
        $itemID = 0; // Default to 0
        switch ($pizzaChoice) {
            case 'Margherita':
                $itemID = 31; // Margherita Pizza
                break;
            case 'Pepperoni':
                $itemID = 32; // Pepperoni Pizza
                break;
            case 'Veggie Delight':
                $itemID = 33; // Veggie Delight Pizza
                break;
            case 'Cheesy Delight':
                $itemID = 34; // Cheesy Delight Pizza
                break;
            case 'Potato Pizza':
                $itemID = 35; // Potato Pizza
                break;
            case 'Shroomzza':
                $itemID = 36; // Shroomzza Pizza
                break;
        }

        // Add order to the cart and the database if quantity is greater than 0
        if ($quantity > 0) {
            // Insert into the database
            $stmt = $db->prepare("INSERT INTO Orders (orderID, itemID, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $newOrderID, $itemID, $quantity);
            if ($stmt->execute()) {
                $successMessage = "$quantity x $pizzaChoice Pizza Meal has been successfully added.";
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
    <title>PengYu's Pizzas - Set Meal</title>
    <link rel="stylesheet" href="stylesmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        <?php if ($successMessage): ?>
        window.onload = function() {
            alert("<?php echo $successMessage; ?>");
            window.location.href = 'Menumeal.php';
        };
        <?php endif; ?>
    </script>
</head>
<body>

   <!-- Header Section -->
   <header>
    <nav class="nav-left">
        <a href="MainPage.php">Home</a>
        <a href="MenuPizza.html" class="active-page">Menu</a>
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
        <img src="Menu Page Banner.png" alt="Menu Banner">
    </section>

    <!-- Set Meal Section -->
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

        <div class="menu-items">
            <div class="meal-description">
                <h2>Pick Any Pizza, Plus Iced Lemon Tea & Fries</h2>
                <p>Choose any medium sized pizza from our menu and enjoy it with a refreshing Iced Lemon Tea 
                    and a side of crispy Himalayan Fries for a perfect meal combination for $22.90!</p>
            </div>

            <form class="set-meal-form" method="POST" action="">
                <div class="form-group">
                    <label for="pizza-choice">Choose your Pizza:</label>
                    <select id="pizza-choice" name="pizza-choice">
                        <option value="Margherita">Margherita Pizza</option>
                        <option value="Pepperoni">Pepperoni Pizza</option>
                        <option value="Veggie Delight">Veggie Delight</option>
                        <option value="Cheesy Delight">Cheesy Delight</option>
                        <option value="Potato Pizza">Potato Pizza</option>
                        <option value="Shroomzza">Shroomzza</option>
                    </select>
                </div>

                <div class="meal-includes">
                    <h3>Your Set Meal Includes:</h3>
                    <ul>
                        <li>Iced Lemon Tea</li>
                        <li>Himalayan Fries</li>
                    </ul>
                </div>

                <div class="form-group"> 
                    <label for="personalizedQty">Quantity:</label>
                    <input type="number" min="0" id="personalizedQty" name="pizzaQty" value="0">
                </div>

                <p class="price">Total Price: $22.90</p>
                <button type="submit" name="addPizza">Add to Cart</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>Co-founder: Peng Teng Kang & Yu Liguang</p>
        <p>PengYu's Pizza © 2024</p>
    </footer>

</body>
</html>
