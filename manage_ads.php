<?php
session_start();
// Include necessary files and initialize database connection
include_once("classes/connect.php");
include_once("classes/database.php");
//include_once("classes/database2.php");


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the user is a Star Member (assuming 'role' determines membership level)
if ($_SESSION['role'] !== 'star_member') {
    // Redirect to home page or display an error message
    header("Location: index.php");
    exit();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the "Edit Selected" button is clicked
    if (isset($_POST["edit_selected"])) {
        // Redirect to the editing page with selected ad IDs as URL parameters
        $selected_ads = isset($_POST["selected_ads"]) ? $_POST["selected_ads"] : array();
        if (!empty($selected_ads)) {
            $ad_ids = implode(",", $selected_ads);
            header("Location: edit_ad.php?ids=$ad_ids");
            exit();
        }
    }

    // Check if the "Pause Selected" or "Resume Selected" button is clicked
    if (isset($_POST["pause_selected"]) || isset($_POST["resume_selected"])) {
        // Update the status of selected ads based on the button clicked
        $status = isset($_POST["pause_selected"]) ? "paused" : "active";
        $selected_ads = isset($_POST["selected_ads"]) ? $_POST["selected_ads"] : array();
        if (!empty($selected_ads)) {
            $ad_ids = implode(",", $selected_ads);
            // Update the status of ads in the database
            $sql = "UPDATE ads SET status = '$status' WHERE id IN ($ad_ids)";
            if (mysqli_query($conn, $sql)) {
                // Redirect back to the ad management dashboard page
                header("Location: dashboard.php");
                exit();
            } else {
                // Error handling if update fails
                echo "Error updating ad status: " . mysqli_error($conn);
            }
        }
    }

    // Check if the "Delete Selected" button is clicked
    if (isset($_POST["delete_selected"])) {
        // Delete selected ads from the database
        $selected_ads = isset($_POST["selected_ads"]) ? $_POST["selected_ads"] : array();
        if (!empty($selected_ads)) {
            $ad_ids = implode(",", $selected_ads);
            // Delete ads from the database
            $sql = "DELETE FROM ads WHERE id IN ($ad_ids)";
            if (mysqli_query($conn, $sql)) {
                // Redirect back to the ad management dashboard page
                header("Location: dashboard.php");
                exit();
            } else {
                // Error handling if deletion fails
                echo "Error deleting ads: " . mysqli_error($conn);
            }
        }
    }
}
?>
