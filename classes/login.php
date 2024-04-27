<?php
class Login
{
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Method to authenticate user login
    public function authenticate($email, $password, $role)
    {
        // Prepare and bind parameters to prevent SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ? AND role = ?");
        $stmt->bind_param("ss", $email, $role);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows == 1) {
            // Fetch user data
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, return user data
                return $user;
            } else {
                // Password is incorrect
                return false;
            }
        } else {
            // User does not exist or doesn't have the specified role
            return false;
        }
    }
}

// Instantiate the Login class with a database connection
$login = new Login($conn); // Assuming $conn is your database connection

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the email, password, and role are provided
    if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['role'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role']; // Get the selected role from the form

        // Authenticate user
        $user = $login->authenticate($email, $password, $role);

        // Check authentication result
        if ($user) {
            // Start session and set session variables
            session_start();
            $_SESSION['user_id'] = $user['id'];

            // Redirect to the index page
            header("Location: index.php");
            exit();
        } else {
            // Set error message for invalid credentials
            $error_message = "Invalid email address, password, or role.";
        }
    } else {
        // Set error message if email, password, or role is not provided
        $error_message = "Email, password, and role are required.";
    }
}