<?php
// Include database connection and any necessary classes
include_once("classes/connect.php");
include_once("classes/database.php");

// Retrieve payment information from the database
if (isset($_GET['payment_id'])) {
    $paymentId = $_GET['payment_id'];
    $sql = "SELECT * FROM payments WHERE payment_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $paymentId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $payment = mysqli_fetch_assoc($result);
    } else {
        // Handle error if payment not found
        echo "Payment not found";
        exit();
    }
} else {
    // Handle error if payment ID is not provided
    echo "Payment ID is missing";
    exit();
}

// Function to format amount with currency symbol
function formatAmount($amount) {
    return "$" . number_format($amount, 2);
}

// Function to format date
function formatDate($date) {
    return date("F j, Y", strtotime($date));
}

// Function to generate payment receipt
function generateReceipt($payment) {
    $receipt = "
        <div style='font-family: Arial, sans-serif;'>
            <h2>Payment Receipt</h2>
            <p><strong>Payment ID:</strong> {$payment['payment_id']}</p>
            <p><strong>Date:</strong> " . formatDate($payment['payment_date']) . "</p>
            <p><strong>Amount:</strong> " . formatAmount($payment['amount']) . "</p>
            <p><strong>Status:</strong> {$payment['status']}</p>
            <!-- Add more payment details as needed -->
        </div>
    ";
    return $receipt;
}

// Generate the receipt
$receiptContent = generateReceipt($payment);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>

<body>
    <?php echo $receiptContent; ?>
</body>

</html>
