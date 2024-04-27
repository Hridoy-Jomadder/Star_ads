<?php
class Database
{
    private $conn;
    private $error;

    public function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);

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
        return $this->conn->prepare($sql);
    }

    public function getError()
    {
        return $this->error;
    }
}
