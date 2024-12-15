<?php
    // Start session
    session_start();
    include "dbconnect.php";

    //Record payment method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Store payment method in session
        if (isset($_POST['Payment'])) {
            $_SESSION['paymentMethod'] = $_POST['Payment'];
        } else {
            $_SESSION['paymentMethod'] = "Not specified"; // Default if no payment method selected
        }
    }
    
    // Check if there is a deletion message in the session
    if (isset($_SESSION['deleteMessage'])) {
        echo "<script>alert('" . $_SESSION['deleteMessage'] . "');</script>";
        unset($_SESSION['deleteMessage']); // Clear the message after displaying
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
    <style>
    .delivery-form {
        background-color: #e4efde;
        padding: 50px 0;
        width: 100%;
    }

    /* Container to center the form and order details */
    .delivery-form-container {
        width: 80%;
        margin: 0 auto;
    }

    .cart-section {
        padding: 20px 0;
    }

    .cart-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .cart-header h2 {
        font-family: 'Serif', 'Garamond';
        font-size: 30px;
    }

    .cart-items {
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
    }

    .cart-items th, .cart-items td {
        border: 1px solid #4a5e38;
        padding: 8px;
        text-align: center;
    }

    .cart-items th {
        background-color: #4a5e38;
        border: 1px solid #e4efde;
        color: white;
        font-family: Arial, Helvetica, sans-serif;
    }

    .cart-summary {
        margin: 20px auto;
        width: 80%;
        text-align: right;
        font-family: Arial, Helvetica, sans-serif;
        padding-left: 880px;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        box-sizing: border-box;
        font-size: 16px;
    }

    .checkbox {
        margin-right: 10px;
    }

    .add-to-cart-button {
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

    .add-to-cart-button:hover {
        background-color: #569e49;
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
          <img src="Logo.png" alt="PengYu's Pizza Logo" 
          width="50"><h1>PengYu's Pizza</h1>
      </div>
      <nav class="nav-right">
        <a href="AboutUs.html" class="active-page">About Us</a>
        <a href="Feedbackpage.php">Reviews</a>
        <a href="trackorder.php">Track Order</a>
        <a href="cart.php"><img src="cart-icon.png" alt="Cart" class="logo-img" width="30" height="25"></a>
        </nav>
    </header>

    <!-- Main Banner Section -->
    <section class="banner">
        <img src="Cart Banner.png" alt="Pizza Banner">
    </section>

    <!-- Delivery Form Section -->
            <section class="delivery-form">
                <div class="delivery-form-container">
                <!-- Cart Section -->
                <div class="cart-section">
                    <?php
                    // Display errors
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);

                    // Check if orderID is set in the session
                    if (!isset($_SESSION['orderID'])) {
                        echo "<p>No active orders found.</p>";
                        exit;
                    }

                    // Retrieve and display orders from the database for the current session's orderID
                    $newOrderID = $_SESSION['orderID'];
                    $result = $db->query("
                        SELECT O.orderID, I.itemID, I.itemName, O.quantity, O.thickness, O.sauce, I.price
                        FROM Orders O
                        JOIN Items I ON O.itemID = I.itemID
                        WHERE O.orderID = $newOrderID
                        ORDER BY O.orderID DESC
                    ");

                    echo '<h2 class="cart-header">Order Details:</h2>';

                    // Display the latest orders
                    if ($result->num_rows > 0) {
                        echo '<table border="1" class="cart-items">';
                        echo '<tr><th>Order ID</th><th>Item</th><th>Quantity</th>
                        <th>Thickness</th><th>Sauce</th><th>Price</th><th>Delete item</th></tr>';
                        
                        $totalSum = 0; // Initialize total sum variable

                        while ($row = $result->fetch_assoc()) {
                            $price = $row['price']; // Get the item price
                            $quantity = $row['quantity']; // Get the quantity
                            $itemTotal = $price * $quantity; // Calculate the total for the item
                            $itemID = $row['itemID'];

                            // Add to the total sum
                            $totalSum += $itemTotal;

                            echo "<tr>";
                            echo "<td>" . $row['orderID'] . "</td>";
                            echo "<td style='width: 500px;'>" . nl2br(htmlspecialchars($row['itemName'], ENT_QUOTES, 'UTF-8')) . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['thickness'] . "</td>";
                            echo "<td>" . $row['sauce'] . "</td>";
                            echo "<td>$" . number_format($itemTotal, 2) . "</td>"; // Display item total
                            // Add delete form with trash can button
                            echo "<td>
                            <form action='deleteOrder.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='orderID' value='" . $row['orderID'] . "'>
                                <input type='hidden' name='itemID' value='" . $row['itemID']. "'>
                                <button type='submit' style='background: none; border: none; cursor: pointer;'>
                                    <img src='trash-icon.png' alt='Delete' width='20' height='20'>
                                </button>
                            </form>
                            </td>";
                            echo "</tr>";
                            echo "</tr>";
                        }

                        echo "</table>";
                        echo "<h2 class='cart-summary'>Total Amount: $" . number_format($totalSum, 2) . "</h2>"; // Display total sum
                    } else {
                        echo "<p>No recent orders found.</p>";
                    }
                    ?>
                </div>
                <br>

                
                    <form action="OrderCompletion.php" method="POST">
                        <div class="Delivery-Address">
                            <label for="Delivery-Address"><h2>Delivery Address:</h2></label>
                            <input type="text" id="Delivery-Address" name="Delivery-Address" placeholder="Please Enter Delivery Address" class="form-input" required>
                        </div>

                        <div class="Phone-Number">
                            <label for="Phone-Number"><h2>Phone Number:</h2></label>
                            <input type="tel" id="Phone-Number" name="Phone-Number" placeholder="8-digit number starting with 8 or 9" class="form-input" pattern="[89][0-9]{7}" 
                                title="Please enter an 8-digit phone number starting with 8 or 9" required>
                        </div>

                <!-- Payment Section -->
                <div class="Payment">
                    <label><h2>Method of Payment:</h2></label><br /><br />
                    
                    <div>
                        <input type="radio" id="creditCard" name="Payment" value="Credit Card" class="checkbox" requried>
                        <label for="creditCard">Credit Card</label><br>
                    
                        <input type="radio" id="cash" name="Payment" value="Cash" class="checkbox">
                        <label for="cash">Cash</label>
                    </div>
                
                </div>

                 <!-- Credit Card Information (initially hidden) -->
                <div id="creditCardInfo" style="display: none;">
                    <h2><br>Credit Card Information:</h2>
                    <label for="cardNumber">Card Number: (16 digits)</label>
                    <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter your card number" 
                    class="form-input" pattern="\d{16}" title="xxxx-xxxx-xxxx-xxxx" required>
                    
                    <label for="expiryDate">Expiration Date (MM/YY):</label>
                    <input type="text" id="expiryDate" name="expiryDate" placeholder="MM/YY" class="form-input" 
                    pattern="^(0[1-9]|1[0-2])\/\d{2}$" title="MM/YY" required>
                    
                    <label for="cvv">CVV:</label>
                    <input type="text" id="cvv" name="cvv" placeholder="CVV" class="form-input" 
                    pattern="\d{3}" title="xxx" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="add-to-cart-button" name="placeOrder">Place Order</button>
            </form>
        </div>
    </section>

    <footer>
        <p>Co-founders: Peng Teng Kang & Yu Liguang</p>
        <p>PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>
<!-- JavaScript to handle showing credit card info -->

<script>
    const creditCardRadio = document.getElementById('creditCard');
    const cashRadio = document.getElementById('cash');
    const creditCardInfo = document.getElementById('creditCardInfo');

    // Get the credit card fields
    const cardNumber = document.getElementById('cardNumber');
    const expiryDate = document.getElementById('expiryDate');
    const cvv = document.getElementById('cvv');

    // Show/hide credit card information fields and toggle "required" attribute
    creditCardRadio.addEventListener('change', () => {
        creditCardInfo.style.display = 'block'; // Show credit card info
        // Add "required" attribute to credit card fields
        cardNumber.required = true;
        expiryDate.required = true;
        cvv.required = true;
    });

    cashRadio.addEventListener('change', () => {
        creditCardInfo.style.display = 'none'; // Hide credit card info
        // Remove "required" attribute from credit card fields
        cardNumber.required = false;
        expiryDate.required = false;
        cvv.required = false;
    });
</script>