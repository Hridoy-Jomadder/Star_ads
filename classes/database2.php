<?php


// Check if the user is logged in and is a Star Member
function check_authentication() {
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        header("Location: login.php");
        exit();
    }
    // if ($_SESSION['role'] == 'star_member') {
    //     // Redirect to home page or display an error message
    //     header("Location: index.php");
    //     exit();
    // }
}

// Function to fetch ads from the database
function fetch_ads() {
    global $conn;
    $ads = array();
    $sql = "SELECT * FROM ads";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ads[] = $row;
        }
    }
    return $ads;
}

// Function to update ad details in the database
function update_ad($ad_id, $new_title, $new_description) {
    global $conn;
    $sql = "UPDATE ads SET title = '$new_title', description = '$new_description' WHERE id = $ad_id";
    return mysqli_query($conn, $sql);
}

// Function to pause or resume an ad
function toggle_ad_status($ad_id, $status) {
    global $conn;
    $sql = "UPDATE ads SET status = '$status' WHERE id = $ad_id";
    return mysqli_query($conn, $sql);
}

// Function to delete an ad from the database
function delete_ad($ad_id) {
    global $conn;
    $sql = "DELETE FROM ads WHERE id = $ad_id";
    return mysqli_query($conn, $sql);
}

// Function to log ad management actions
function log_action($action, $ad_id) {
    // Implement logging logic here, such as writing to a log file or database table
}

// Example usage:

// Check authentication before accessing the dashboard
check_authentication();

// Fetch ads from the database
$ads = fetch_ads();

// Handle form submission for updating ad details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Example: Update ad details
    $ad_id = $_POST['ad_id'];
    $new_title = $_POST['new_title'];
    $new_description = $_POST['new_description'];
    if (update_ad($ad_id, $new_title, $new_description)) {
        // Log the update action
        log_action("update", $ad_id);
        // Redirect or display success message
    } else {
        // Handle update failure
    }
}

// Similar logic for pausing/resuming ads and deleting ads


