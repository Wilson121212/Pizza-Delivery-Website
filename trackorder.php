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
            padding-left: 980px;
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
        .links a {
            text-decoration: underline; 
            color: #000; 
            font-size: 14px; 
        }

        .links a:hover {
            color: #02542D; 
        }
        .payment-method {
            display: none;
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
        <a href="trackorder.php" class="active-page">Track Order</a>
        <a href="cart.php"><img src="cart-icon.png" alt="Cart" class="logo-img" width="30" height="25"></a>
        </nav>
    </header>

    <!-- Main Banner Section -->
    <section class="banner">
        <img src="Track Banner.png" alt="Pizza Banner">
    </section>

    <!-- Delivery Form Section -->
    <section class="delivery-form">
        <div class="delivery-form-container">
            <form action="" method="POST">
                <div class="Order-Number">
                    <label for="Order-Number"><h2>Enter Your Order Number:</h2></label>
                    <input type="number" id="Order-Number" name="orderID" class="form-input" required>
                </div>

                <!-- Cart Section -->
                <div class="cart-section">
                    <?php
                    // Start session
                    session_start();
                    include "dbconnect.php";

                    // Display errors
                    ini_set('display_errors', 1);
                    error_reporting(E_ALL);

                    // Check if form has been submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Get the order ID from the form
                        $newOrderID = $_POST['orderID'];

                        // Retrieve and display orders from the database for the provided orderID
                        $result = $db->query("
                            SELECT O.orderID, I.itemName, O.quantity, O.thickness, O.sauce, I.price
                            FROM Orders O
                            JOIN Items I ON O.itemID = I.itemID
                            WHERE O.orderID = $newOrderID
                            ORDER BY O.orderID DESC
                        ");

                        echo '<h2 class="cart-header">Order Details:</h2>';

                        // Display the latest orders
                        if ($result && $result->num_rows > 0) {
                            echo '<table border="1" class="cart-items">';
                            echo '<tr><th>Order ID</th><th>Item</th><th>Quantity</th><th>Thickness</th><th>Sauce</th><th>Price</th></tr>';
                            
                            $totalSum = 0; // Initialize total sum variable

                            while ($row = $result->fetch_assoc()) {
                                $price = $row['price']; // Get the item price
                                $quantity = $row['quantity']; // Get the quantity
                                $itemTotal = $price * $quantity; // Calculate the total for the item

                                // Add to the total sum
                                $totalSum += $itemTotal;

                                echo "<tr>";
                                echo "<td>" . $row['orderID'] . "</td>";
                                echo "<td>" . $row['itemName'] . "</td>";
                                echo "<td>" . $row['quantity'] . "</td>";
                                echo "<td>" . $row['thickness'] . "</td>";
                                echo "<td>" . $row['sauce'] . "</td>";
                                echo "<td>$" . number_format($itemTotal, 2) . "</td>"; // Display item total
                                
                                echo "</tr>";
                            }

                            echo "</table>";
                            echo "<br><h4>Your order is now being prepared in the kitchen.</h4>";
                            echo "<h2 class='cart-summary'>Total Amount: $" . number_format($totalSum, 2) . "</h2>"; // Display total sum
                        } else {
                            echo "<p>No orders found for Order ID: $newOrderID.</p>";
                        }
                    }
                    ?>
                </div>
                <br>

                <!-- Payment Section (Initially Hidden) -->
                <div class="payment-method">
                    <div class="Payment">
                        <h2>Payment by: 
                            <?php
                                // Check if payment method is set in the session and display it
                                if (isset($_SESSION['paymentMethod'])) {
                                    echo htmlspecialchars($_SESSION['paymentMethod']);
                                } else {
                                    echo "Not specified";
                                }
                            ?> 
                        </h2>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="add-to-cart-button">Track Order</button>
                <div class="links">
                <a href="MainPage.php">Back to Main Page</a><br><br>
                <a href="logout.php">Log out Session</a>
                </div>
            </form>
        </div>
    </section>

    <footer>
        <p>Co-founders: Peng Teng Kang & Yu Liguang</p>
        <p>PengYu's Pizza © 2024</p>
    </footer>
</body>
</html>

 <!-- JavaScript to Show Payment Method after Tracking Order -->
 <script>
        const trackOrderButton = document.getElementById('trackOrderButton');
        const paymentMethodSection = document.querySelector('.payment-method');

        trackOrderButton.addEventListener('click', function() {
            // Show the payment method section after the button is clicked
            paymentMethodSection.style.display = 'block';
        });
    </script>