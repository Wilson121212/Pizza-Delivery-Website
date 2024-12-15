<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'pengyus_pizza'; // Database name
$username = 'root'; // Database username
$password = ''; // Database password

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($_GET['name'])) {
    $name = $_GET['name'];
    $email = $_GET['email'];
    $feedback = $_GET['feedback'];
    $rating = $_GET['rating'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $email, $feedback, $rating);

    // Execute the statement
    $stmt->execute();
    
    $stmt->close();
}

// Fetch existing feedback
$result = $conn->query("SELECT * FROM feedback ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PengYu's Pizzas - Feedback</title>
    <link rel="stylesheet" href="stylesmenu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles for feedback display */
        .feedback-list {
            margin-top: 20px;
        }
        .feedback-item {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .feedback-item h4 {
            margin: 0;
        }
        .feedback-item p {
            margin: 5px 0;
        }
        .feedback-item .rating {
            font-weight: bold;
        }
        .form-group {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #f9f9f9;
        max-width: 100%; /* Make it as wide as the form */
        box-sizing: border-box; /* Ensures padding is included in total width */
    }
        .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        font-size: 1em;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
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
            <a href="FeedbackPage.php" class="active-page">Reviews</a>
            <a href="trackorder.php">Track Order</a>
            <a href="cart.php"><img src="cart-icon.png" alt="Cart" class="logo-img" width="30" height="25"></a>
        </nav>
    </header>

    <!-- Main Banner Section -->
    <section class="banner">
        <img src="Review Banner.png" alt="Menu Banner">
    </section>
w
    <!-- Feedback Form Section -->
    <section class="feedback">
        <h2>We Value Your Feedback</h2>
        <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" class="Feedback">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback:</label>
                <textarea id="feedback" name="feedback" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="rating">Rating:</label>
                <select id="rating" name="rating">
                    <option value="5">5 - Excellent</option>
                    <option value="4">4 - Good</option>
                    <option value="3">3 - Average</option>
                    <option value="2">2 - Below Average</option>
                    <option value="1">1 - Poor</option>
                </select>
            </div>

            <button type="submit">Submit Review</button>
        </form>

        <!-- Display Feedback -->
        <div class="feedback-list">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="feedback-item">
                        <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                        <p><?php echo htmlspecialchars($row['feedback']); ?></p>
                        <p class="rating">Rating: <?php echo htmlspecialchars($row['rating']); ?> stars</p>
                        <p><em><?php echo $row['created_at']; ?></em></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No feedback submitted yet.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>Co-founder: Peng Teng Kang & Yu Liguang</p>
        <p>PengYu's Pizza © 2024</p>
    </footer>

</body>
</html>

<?php
$conn->close();
?>
