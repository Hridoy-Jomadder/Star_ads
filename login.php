<?php
session_start();

// Include necessary files
include_once("classes/connect.php");
include_once("classes/database.php");
include_once("classes/login.php");

// Connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ads_db";

// Create a new instance of the Database class
$database = new Database($servername, $username, $password, $dbname);

// Check for connection errors
if ($database->getError()) {
    die("Connection failed: " . $database->getError());
}

// Get the database connection object
$conn = $database->getConnection();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) { // Assuming 'user_id' is the key used to store the user's ID in the session
    // Redirect to the index page
    header("Location: index.php");
    exit();
}

// Initialize variables
$email = "";
$password = "";

$error_message = "";

// Instantiate Database class with connection parameters
$DB = new Database($servername, $username, $password, $dbname);

// Instantiate Login class with database connection
$login = new Login($DB->getConnection());

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


// Display error message if present
if (!empty($error_message)) {
    echo "Login failed: " . $error_message;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Star - Ads</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta content="Hridoy Jomadder" name="author">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="text-primary" style="font-family: times new roman;"><i class="fa fa-star me-2"></i>STAR_ADS</h3>
                        </div>

                        <?php
                        if (!empty($error_message)) {
                            // Display specific error messages based on the situation
                            if ($error_message === "Invalid email address, password, or role.") {
                                echo "Authentication failed. Invalid email address, password, or role.";
                            } else {
                                echo "An error occurred during login.";
                            }
                        }
                        ?>
<!-- <form method="post" action="login.php">
    <input type="text" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">
    <select name="role">
        <option value="Personal">Personal</option>
        <option value="Company">Company</option>
        <option value="Star Member">Star Member</option>
    </select>
    <button type="submit">Login</button>
</form> -->



                    <form method="post" action="login.php">
                        <div class="form-floating mb-3">
                            <input name="email" class="form-control" value="<?php echo htmlspecialchars($email); ?>" type="text" id="email" placeholder="Email Address" style="font-family: times new roman;">
                            <label for="email">Email Address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input name="password" class="form-control" value="<?php echo htmlspecialchars($password); ?>" type="password" id="password" placeholder="Password" style="font-family: times new roman;">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-3">
                        <select name="role" class="form-select" id="role" style="font-family: times new roman;">
                            <option value="">Select Role</option>
                            <option value="Personal">Personal</option>
                            <option value="Company">Company</option>
                            <option value="Star Member">Star Member</option>
                        </select>

                            <label for="role">Role</label>
                        </div>

                        <input type="submit" class="btn btn-primary py-3 w-100 mb-4" id="button" value="Log in" style="font-family: times new roman;"><br><br>
                        <p class="text-center mb-0">Don't have an Account? <a href="signup.php" style="font-family: times new roman;">Sign Up</a></p>
                    </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html> 