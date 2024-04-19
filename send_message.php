<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    
    // Here you would handle the email sending process
    // For example:
    $to = "your_email@example.com";
    $message = "Name: $name\nEmail: $email\nSubject: $subject";
    $headers = "From: $email";
    
    if (mail($to, $subject, $message, $headers)) {
        echo "Message sent successfully.";
    } else {
        echo "Failed to send message. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
