<?php
session_start();
// Include necessary files and initialize database connection
include_once("classes/connect.php");
include_once("classes/database.php");
include_once("classes/database2.php");


// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}


?>

<!-- HTML for the ad management dashboard page -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Management Dashboard</title>
    <!-- Include CSS files -->
</head>
<body>
    <header>
        <!-- Navigation bar or header -->
    </header>

    <div class="container">
        <h1>Ad Management Dashboard</h1>

        <!-- Ad Selection Section -->
        <h2>Ad Selection</h2>
        <form action="manage_ads.php" method="post">
            <!-- Display ads with checkboxes for selection -->
            <!-- Example: <input type="checkbox" name="selected_ads[]" value="ad_id"> Ad Title -->
            <!-- Repeat for each ad -->
            <button type="submit" name="edit_selected">Edit Selected</button>
            <button type="submit" name="pause_selected">Pause Selected</button>
            <button type="submit" name="resume_selected">Resume Selected</button>
            <button type="submit" name="delete_selected">Delete Selected</button>
        </form>

        <!-- Editing Section -->
        <h2>Editing</h2>
        <form action="edit_ad.php" method="post">
            <!-- Input fields for editing ad details -->
            <!-- Example: <input type="text" name="title" value="Ad Title"> -->
            <!-- Repeat for each editable field -->
            <button type="submit" name="save_changes">Save Changes</button>
        </form>

        <!-- Monitoring Performance Section -->
        <h2>Monitoring Performance</h2>
        <!-- Display performance metrics and analytics -->
        <!-- Example: Display a chart showing impressions, clicks, CTR, etc. -->
    </div>

    <footer>
        <!-- Footer content -->
    </footer>

    <!-- Include JavaScript files -->
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ad Management Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h1>Ad Management Dashboard</h1>
        <div class="ads">
            <h2>Ads</h2>
            <?php foreach ($ads as $ad): ?>
                <div class="ad">
                    <h3><?php echo $ad['title']; ?></h3>
                    <p><?php echo $ad['description']; ?></p>
                    <form action="edit_ad.php" method="post">
                        <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                        <button type="submit">Edit</button>
                    </form>
                    <form action="manage_ads.php" method="post">
                        <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                        <?php if ($ad['status'] == 'active'): ?>
                            <button type="submit" name="action" value="pause">Pause</button>
                        <?php else: ?>
                            <button type="submit" name="action" value="resume">Resume</button>
                        <?php endif; ?>
                    </form>
                    <form action="manage_ads.php" method="post">
                        <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                        <button type="submit" name="action" value="delete">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="performance">
            <h2>Performance Metrics</h2>
            <!-- Add visualizations for ad performance metrics here -->
        </div>
    </div>
</body>
</html>

