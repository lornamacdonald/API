<?php
class Client {

    // Database connection and table name
    private $conn;
    private $table_name = "Client";

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // View a client
    function readOne($keywords) {
        // Query to read single record
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE client_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // View a client's first name
    function displayFirstName($keywords) {
        // SQL query
        $query = "SELECT firstName FROM " . $this->table_name . "
                  WHERE client_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Delete a client
    function delete($keywords) {
        // SQL query
        $query = "DELETE FROM Client
                  WHERE client_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Add a client
    function create() {
        // SQL query
        $query = "INSERT INTO " . $this->table_name . "
        SET firstName=:firstName, lastName=:lastName, genderName=:genderName, dob=:dob, phone=:phone, email=:email,
        password=:password, address=:address, town=:town, county=:county, postcode=:postcode";
        // Prepare query
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(":firstName", $this->firstName);
        $stmt->bindParam(":lastName", $this->lastName);
        $stmt->bindParam(":genderName", $this->genderName);
        $stmt->bindParam(":dob", $this->dob);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":county", $this->county);
        $stmt->bindParam(":postcode", $this->postcode);
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update a client
    function update() {
        // SQL query
        $query = "UPDATE " . $this->table_name . "
        SET phone=:phone, email=:email,
        password=:password, address=:address, town=:town, county=:county, postcode=:postcode
        WHERE client_ID=:client_ID";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(":client_ID", $this->client_ID);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":town", $this->town);
        $stmt->bindParam(":county", $this->county);
        $stmt->bindParam(":postcode", $this->postcode);
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Check user exists
    function checkUserExists($keywords) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . "
        WHERE email = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Login
    function login($keywords, $keywords2) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . "
        WHERE email = ? AND password = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Check user exists
    function getClientID($keywords) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . "
        WHERE email = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }
}
?>