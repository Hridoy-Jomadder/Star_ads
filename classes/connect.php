<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ads_db";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // Handle connection errors gracefully
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, set charset and other connection settings here
$conn->set_charset("utf8mb4");
// ...

// Optionally, close the connection when it's no longer needed
// $conn->close();

?>


	<!-- function read($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn,$query);

		if(!$result)
		{
			return false;
		}
		else
		{
			$data = false;
			while($row = mysqli_fetch_assoc($result))
			{

				$data[] = $row;

			}

			return $data;
		}
	}

	function save($query)
	{
		$conn = $this->connect();
		$result = mysqli_query($conn,$query);

		if(!$result)
		{
			return false;
		}else
		{
			return true;
		}
	}

}
 -->
