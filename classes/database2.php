<?php

class Database2 {
    private $conn;

    public function __construct($host, $username, $password, $database) {
        // Create connection
        $this->conn = new mysqli($host, $username, $password, $database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getDashboardData() {
        // SQL query to retrieve data
        $sql = "SELECT id, userid, first_name, last_name, profile_image, gender, title, date, email, ip_address, country, browser_name FROM users";

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if the query execution was successful
        if ($result === false) {
            // If there was an error, print error message and return null
            echo "Error executing query: " . $this->conn->error;
            return null;
        }

        // Check if there are results
        if ($result->num_rows > 0) {
            // Fetch data and return as an associative array
            $data = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $data = array(); // Return an empty array if no data found
        }

        return $data;
    }

  // Method to construct the URL for profile images
  private function constructProfileImageUrl($imageName) {
    // Assuming "Upload Files" folder is in the root directory accessible from the web
    $baseUrl = $_SERVER['HTTP_HOST']; // Use HTTP_HOST for domain name
    $uploadsFolder = "/Star/";
    return "http://" . $baseUrl . $uploadsFolder . $imageName;
}
// Method to delete a user by ID
    public function deleteUserByID($userID) {
        // Define your SQL query to delete a user by ID
        $query = "DELETE FROM users WHERE id = $userID";

        // Execute the query
        $result = $this->conn->query($query);

        // Check if the query executed successfully
        if ($result !== false) {
            return true; // Return true if user deletion is successful
        } else {
            return false; // Return false if user deletion failed
        }
    }
// Method to fetch all users from the database
 public function fetchAllUsers() {
     // Define your SQL query to fetch all users
     $query = "SELECT * FROM users";

     // Execute the query
     $result = $this->conn->query($query);

     // Check if the query executed successfully and if there are any results
     if ($result !== false && $result->num_rows > 0) {
         // Fetch all users and return them as an associative array
         $users = $result->fetch_all(MYSQLI_ASSOC);

                     // Append the profile image URL to each user
                     foreach ($users as &$user) {
                        $user['profile_image_url'] = $this->constructProfileImageUrl($user['profile_image']);
                    }
        
         return $users;
     } else {
         // Return false if no users are found or an error occurred
         return false;
     }
 }
// Method to get user details by ID
public function getUserByID($userID) {
    // Define your SQL query to fetch user details by ID
    $query = "SELECT * FROM users WHERE id = $userID";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query executed successfully and if there are any results
    if ($result !== false && $result->num_rows > 0) {
        // Fetch user details and return as an associative array
        $user = $result->fetch_assoc();

        // Append the profile image URL to the user
        $user['profile_image_url'] = $this->constructProfileImageUrl($user['profile_image']);

        return $user;
    } else {
        // Return false if the user is not found or an error occurred
        return false;
    }
}

// Method to delete a user by ID
public function deleteByID($userID) {
    // Define your SQL query to delete a user by ID
    $query = "DELETE FROM users WHERE id = $userID";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query executed successfully
    if ($result !== false) {
        return true; // Return true if user deletion is successful
    } else {
        return false; // Return false if user deletion failed
    }
}

// Method to fetch all posts from the database
public function fetchAllPosts() {
    // Define your SQL query to fetch all posts
    $query = "SELECT * FROM posts";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query executed successfully and if there are any results
    if ($result !== false && $result->num_rows > 0) {
        // Fetch all posts and return them as an associative array
        $posts = $result->fetch_all(MYSQLI_ASSOC);

        // Append the image URL to each post
        foreach ($posts as &$post) {
            $post['image_url'] = $this->constructImageUrl($post['image']);
        }

        return $posts;
    } else {
        // Return false if no posts are found or an error occurred
        return false;
    }
}
// Method to construct the URL for images
private function constructImageUrl($imageName) {
    // Assuming "Upload Files" folder is in the root directory accessible from the web
    $baseUrl = $_SERVER['HTTP_HOST']; // Use HTTP_HOST for domain name
    $uploadsFolder = "/Star/"; // Change this to your actual folder path
    return "http://" . $baseUrl . $uploadsFolder . $imageName;
}

// Method to fetch video details by ID
public function fetchVideoByID($videoID) {
    // Sanitize the video ID to prevent SQL injection
    $videoID = $this->conn->real_escape_string($videoID);

    // Define your SQL query to fetch video details by ID
    $query = "SELECT * FROM videos WHERE id = '$videoID'";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query executed successfully and if there are any results
    if ($result !== false && $result->num_rows > 0) {
        // Fetch video details and return as an associative array
        $video = $result->fetch_assoc();

        return $video;
    } else {
        // Return false if the video is not found or an error occurred
        return false;
    }
}
// In the Database class

public function fetchAllVideos() {
    // Define your SQL query to fetch all videos
    $query = "SELECT * FROM videos";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query executed successfully and if there are any results
    if ($result !== false && $result->num_rows > 0) {
        // Fetch all video details and return as an array of associative arrays
        $videos = $result->fetch_all(MYSQLI_ASSOC);

        return $videos;
    } else {
        // Return false if no videos are found or an error occurred
        return false;
    }
}

// In the Database class
// Method to delete a video by ID
public function deleteVideoByID($videoID) {
    // Sanitize the video ID to prevent SQL injection
    $videoID = $this->conn->real_escape_string($videoID);

    // Define your SQL query to delete the video by ID
    $query = "DELETE FROM videos WHERE id = '$videoID'";

    // Execute the query
    $result = $this->conn->query($query);

    // Check if the query executed successfully and if any rows were affected
    if ($result !== false && $this->conn->affected_rows > 0) {
        // Video successfully deleted
        return true;
    } else {
        // Failed to delete the video or no video found with the given ID
        return false;
    }
}


    public function __destruct() {
        // Close the connection
        $this->conn->close();
    }
}

// Example usage:
$database = new Database2("localhost", "root", "", "star_db1");
$dashboardData = $database->getDashboardData();

// Display data (you can customize this part based on your requirements)
// if ($dashboardData !== null) {
//     echo "<pre>";
//     print_r($dashboardData);
//     echo "</pre>";
// } else {
//     // Handle the case where dashboard data is null
//     echo "Failed to retrieve dashboard data.";
// }
 

  // Create a new instance of Database2
$database = new Database2("localhost", "root", "", "star_db1");

// Fetch users from the database
$users = $database->fetchAllUsers();

// Display users data (you can customize this part based on your requirements)
// if ($users !== false) {
//     echo "<pre>";
//     print_r($users);
//     echo "</pre>";
// } else {
//     // Handle the case where no users are found or an error occurred
//     echo "Failed to fetch users.";
// }


// Fetch posts from the database
$posts = $database->fetchAllPosts();

// Display posts data in the HTML table
// if ($posts !== false) {
//     foreach ($posts as $post) {
//         echo "<tr>";
//         echo "<td><img src=\"{$post['image_url']}\" alt=\"Image\" width=\"50\" height=\"50\"></td>";
//         echo "<td><a class=\"btn btn-sm btn-info\" href=\"postid_detail.php?id={$post['postid']}\">Detail</a></td>";
//         echo "<td><a class=\"btn btn-sm btn-warning\" href=\"postid_delete.php?id={$post['postid']}\">Delete</a></td>";
//         echo "</tr>";
//     }
// } else {
//     // Handle the case where no posts are found or an error occurred
//     echo "<tr><td colspan='9'>No posts found.</td></tr>";
// }

$videos = $database->fetchAllVideos();
