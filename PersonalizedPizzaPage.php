<?php
session_start();
include "dbconnect.php";
// Display errors
ini_set('display_errors', 1);
error_reporting(E_ALL);


// Initialize success messages
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

    if (isset($_POST['addpersonalized'])) {
        // Determine itemID based on selected size
        $size = $_POST['personalizedSize'];
        $thickness = $_POST['personalizedthickness'];
        $sauce = $_POST['personalizedsauce'];
        $quantity = isset($_POST['personalizedQty']) ? (int)$_POST['personalizedQty'] : 0;
        $toppings = isset($_POST['toppings']) ? (array)$_POST['toppings'] : [];

        // Convert toppings array to a comma-separated string
        $toppingsString = implode(",", $toppings);

        // Set itemID based on size
        $itemID = 0; // Default to 0
        switch ($size) {
            case 'small':
                $itemID = 21; // Small
                break;
            case 'medium':
                $itemID = 22; // Medium
                break;
            case 'large':
                $itemID = 23; // Large
                break;
        }

        if ($quantity > 0) {
           
            // Insert into the database
            $stmt = $db->prepare("INSERT INTO Orders (orderID, itemID, quantity, thickness, sauce, toppings) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisss", $newOrderID, $itemID, $quantity, $thickness, $sauce, $toppingsString);
            if ($stmt->execute()) {
                $successMessage = "$quantity x Personalized Pizza (Size: $size, Thickness: $thickness, Sauce: $sauce) has been successfully added.";
            } else {
                $successMessage = "Error inserting order: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $successMessage = "Please select a quantity greater than 0.";
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="(time in seconds)">
    <title>PengYu's Pizzas - Personalized Pizza</title>
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
        <img src="Customize Banner.png" alt="Menu Banner">
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
    <!-- Personalized Pizza Section -->
        <section class="personalized-pizza">
        <h2>Create Your Own Pizza</h2>
        <form method="post">
            <div class="form-group">
                <label for="size">Select Size:</label><br><br>
                <select id="size" name="personalizedSize">
                    <option value="small">Small - 10" ($7.90)</option>
                    <option value="medium">Medium - 12" ($9.90)</option>
                    <option value="large">Large - 14" ($11.90)</option>
                </select>
            </div>
    
            <div class="form-group">
                <label for="thickness">Select Crust Thickness:</label><br><br>
                <select id="thickness" name="personalizedthickness">
                    <option value="thin">Thin</option>
                    <option value="regular">Regular</option>
                    <option value="thick">Thick</option>
                </select>
            </div>
            <div class="form-group">
                <label for="sauce">Select Sauce:</label><br><br>
                <select id="sauce" name="personalizedsauce">
                    <option value="tomato">Tomato</option>
                    <option value="pesto">Pesto</option>
                    <option value="white_garlic">White Garlic</option>
                </select>
            </div>
    
            <!-- Other form elements go here -->    

            <div class="form-group">
                <label><b>Toppings: </b></label><br><br>
                <div>
                <input type="checkbox" id="pepperoni" name="toppings" value="pepperoni">
                    <label for="pepperoni">Pepperoni</label>
                </div>
                <div>
                <input type="checkbox" id="mushrooms" name="toppings" value="mushrooms">
                    <label for="mushrooms">Mushrooms</label>
                </div>
                <div>
                <input type="checkbox" id="green-peppers" name="toppings" value="green-peppers">
                    <label for="green-peppers">Green Peppers</label>
                </div>
                <div>
                <input type="checkbox" id="onions" name="toppings" value="onions">
                    <label for="onions">Onions</label>
                </div>
                <div>
                <input type="checkbox" id="extra-cheese" name="toppings" value="extra-cheese">
                    <label for="extra-cheese">Extra Cheese</label>
                </div>
                
            </div>
            <div class="form-group"> 
                    <label for="personalizedQty">Quantity:</label>
                    <input type="number" min="0" id="personalizedQty" 
                    name="personalizedQty" value="0" >
            </div>

            <div class="form-group">
                <label for="special-instructions">Special Instructions:</label><br><br>
                <textarea id="special-instructions" rows="4" placeholder="Any special requests?"></textarea>
            </div>
            <button type="submit" class="add-to-cart-button" name="addpersonalized">Add to Cart</button>
        </form>
        </section>
    </main>
    </section>

    <!-- Footer -->
    <footer>
        <p>Co-founder: Peng Teng Kang & Yu Liguang<p>
        <p> PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>
