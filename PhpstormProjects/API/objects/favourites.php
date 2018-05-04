<?php
class Favourites {

    // Database connection and table name
    private $conn;
    private $table_name = "Favourites";

    // Constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // View a list of a client's favourite organisations, of a declared type
    function search($keywords, $keywords2) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " f
        LEFT JOIN Organisation o ON f.organisation_ID = o.organisation_ID
        WHERE f.client_ID = ? AND o.typeName LIKE ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // View a list of a client's favourite organisations
    function displayFavourites($keywords) {
        // SQL query
        $query = "SELECT DISTINCT o.name, f.organisation_ID FROM " . $this->table_name . " f
        LEFT JOIN Organisation o ON f.organisation_ID = o.organisation_ID
        WHERE f.client_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Delete a favourite
    function delete($keywords, $keywords2) {
        // SQL query
        $query = "DELETE FROM " . $this->table_name . "
        WHERE client_ID = ? AND organisation_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete all favourites
    function deleteAll($keywords) {
        // SQL query
        $query = "DELETE FROM " . $this->table_name . "
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

    // Add a favourite
    function create() {
        // SQL query
        $query = "INSERT INTO " . $this->table_name . "
        SET client_ID=:client_ID, organisation_ID=:organisation_ID";
        // Prepare query
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(":client_ID", $this->client_ID);
        $stmt->bindParam(":organisation_ID", $this->organisation_ID);
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Check if an organisation has been favourited
    function isFavourited($keywords, $keywords2) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . "
                  WHERE client_ID = ? AND organisation_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }
}
?>