<?php
// Check if the payment ID is provided in the URL
if (isset($_GET['payment_id'])) {
    // Include the necessary files
    include_once("classes/connect.php");
    include_once("classes/database.php");

    // Get the payment ID from the URL
    $payment_id = $_GET['payment_id'];

    // Retrieve payment details from the database
    $sql = "SELECT * FROM payments WHERE payment_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $payment_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if payment details are found
    if ($result->num_rows > 0) {
        // Fetch payment details
        $payment = $result->fetch_assoc();

        // Display payment details in the receipt
        echo "<h1>Payment Receipt</h1>";
        echo "<p><strong>Payment ID:</strong> " . $payment['payment_id'] . "</p>";
        echo "<p><strong>Amount:</strong> $" . $payment['amount'] . "</p>";
        echo "<p><strong>Date:</strong> " . $payment['payment_date'] . "</p>";
        echo "<p><strong>Status:</strong> " . $payment['status'] . "</p>";

        // Additional details as needed

    } else {
        echo "Payment details not found.";
    }

    // Close database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Payment ID is missing.";
}
?>
