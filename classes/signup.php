<?php
class Signup
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function evaluate($data)
    {
        // Extract data from the form submission
        $username = $data['username'];
        $password = $data['password'];
        $email = $data['email'];
        $country = $data['country'];
        $number = $data['number'];
        $website = $data['website'];
        $address = $data['address'];
        $role = $data['role'];

        // Validate form inputs
        if (empty($username) || empty($password) || empty($email) || empty($country) || empty($number) || empty($website) || empty($address) || empty($role)) {
            return "All fields are required.";
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement with placeholders
        $stmt = $this->conn->prepare("INSERT INTO users (username, password, email, country, number, website, address, role) VALUES ('$username', '$password', '$email', '$country', '$number', '$website', '$address', '$role')");


// Check if the statement preparation was successful
if (!$stmt) {
    return "Error preparing statement: " . $this->conn->error;
}

// Bind parameters to the prepared statement
if (!$stmt->bind_param("ssssssss", $username, $hashedPassword, $email, $country, $number, $website, $address, $role)) {
    return "Error binding parameters: " . $stmt->error;
}

// Execute the query
if ($stmt->execute()) {
    // Registration successful
    return "Registration successful!";
} else {
    // Registration failed
    return "Error executing statement: " . $stmt->error;
}
    }
}