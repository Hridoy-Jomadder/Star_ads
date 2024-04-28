<?php

class Database
{
    private $conn;
    private $error;

    public function __construct($servername, $username, $password, $dbname)
    {
        // Create a new database connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check for connection errors
        if ($this->conn->connect_error) {
            $this->error = $this->conn->connect_error;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function prepare($sql)
    {
        // Prepare a SQL statement
        return $this->conn->prepare($sql);
    }

    public function getError()
    {
        return $this->error;
    }

    // Function to fetch service data from the database
    public function getServices()
    {
        // Initialize an empty array to store service data
        $services = [];

        try {
            // Prepare and execute the SQL query to select all services
            $stmt = $this->conn->prepare("SELECT * FROM services");
            $stmt->execute();

            // Fetch all rows as associative arrays
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Iterate through each row and add it to the services array
            foreach ($result as $row) {
                $service = [
                    'id' => $row['id'],
                    'title' => $row['title'],
                    'description' => $row['description'],
                    'image' => $row['image'],
                    'link' => $row['link']
                ];
                // Add the service to the services array
                $services[] = $service;
            }

            // Return the array of services
            return $services;
        } catch (PDOException $e) {
            // Handle any errors that occur during the database operation
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}

