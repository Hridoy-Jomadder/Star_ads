<?php

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

// Check if ad IDs are provided in the URL parameters
if (!isset($_GET['ids'])) {
    // Redirect back to the ad management dashboard if ad IDs are not provided
    header("Location: project.php");
    exit();
}

// Extract ad IDs from URL parameters
$ad_ids = explode(",", $_GET['ids']);

// Fetch ad details from the database based on provided ad IDs
$ads = array();
foreach ($ad_ids as $ad_id) {
    $sql = "SELECT * FROM ads WHERE id = $ad_id";
    $result = mysqli_query($conn, $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        $ad = mysqli_fetch_assoc($result);
        $ads[] = $ad;
    }
}

// Handle form submission for updating ad details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Loop through each ad to update its details
    foreach ($ads as $ad) {
        // Retrieve updated details from the form
        $new_title = $_POST['title_' . $ad['id']];
        $new_description = $_POST['description_' . $ad['id']];
        // You can include more fields for editing, such as image URL, target URL, etc.

        // Update ad details in the database
        $sql = "UPDATE ads SET title = '$new_title', description = '$new_description' WHERE id = " . $ad['id'];
        if (mysqli_query($conn, $sql)) {
            // Redirect back to the ad management dashboard after successful update
            header("Location: dashboard.php");
            exit();
        } else {
            // Error handling if update fails
            echo "Error updating ad: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ads</title>
</head>
<body>
    <h2>Edit Ads</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <?php foreach ($ads as $ad) { ?>
            <label for="title_<?php echo $ad['id']; ?>">Title:</label>
            <input type="text" name="title_<?php echo $ad['id']; ?>" value="<?php echo $ad['title']; ?>"><br>

            <label for="description_<?php echo $ad['id']; ?>">Description:</label>
            <textarea name="description_<?php echo $ad['id']; ?>"><?php echo $ad['description']; ?></textarea><br>
            <!-- You can include more fields for editing here -->

            <hr>
        <?php } ?>
        <input type="submit" value="Update">
    </form>
</body>
</html>
