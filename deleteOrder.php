<?php
session_start();
include "dbconnect.php";

// Check if orderID and itemID are set
if (isset($_POST['orderID']) && isset($_POST['itemID'])) {
    $orderID = $_POST['orderID'];
    $itemID = $_POST['itemID'];

    // Fetch the item name from the database before deletion
    $stmt = $db->prepare("SELECT itemName FROM Items WHERE itemID = ?");
    $stmt->bind_param("i", $itemID);
    $stmt->execute();
    $stmt->bind_result($itemName);
    $stmt->fetch();
    $stmt->close();

    if ($itemName) {
        // Prepare and execute the delete query
        $stmt = $db->prepare("DELETE FROM Orders WHERE orderID = ? AND itemID = ?");
        $stmt->bind_param("ii", $orderID, $itemID);

        if ($stmt->execute()) {
            // Set the session message with the item name
            $_SESSION['deleteMessage'] = "Item: $itemName has been removed from the cart.";

            // Successful deletion, redirect back to cart page
            header("Location: cart.php");
            exit();
        } else {
            echo "Error deleting item: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Item not found.";
    }
} else {
    echo "Invalid request.";
}
?>
