<?php
class Treatment {

    // Database connection and table name
    private $conn;
    private $table_name = "Treatment";

    // Constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // View a list of treatments an organisation provides
    function search($keywords) {
        // SQL query
        $query = "SELECT DISTINCT t.treatmentName, t.organisation_ID, o.name FROM " . $this->table_name . " t
        LEFT JOIN Organisation o ON o.organisation_ID = t.organisation_ID
        WHERE t.organisation_ID = ? ";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get the ID of a treatment based on staff ID and treatment name
    function getTreatmentID($keywords, $keywords2) {
        // SQL query
        $query = "SELECT t.treatment_ID FROM " . $this->table_name . " t
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        WHERE t.staff_ID = ? AND t.treatmentName = ?";
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