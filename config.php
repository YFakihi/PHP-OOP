<?php

class DatabaseConnection {
    private $conn;

    public function __construct($dbHost, $dbName, $dbUsername, $dbPassword) {
        try {
            $this->conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}

?>