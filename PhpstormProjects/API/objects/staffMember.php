<?php
class StaffMember {

    // Database connection and table name
    private $conn;
    private $table_name = "StaffMember";

    // Constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // View a list of staff in an organisation who offer the specified treatment
    function search($keywords, $keywords2) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " s
        LEFT JOIN Organisation o ON s.organisation_ID = o.organisation_ID
        LEFT JOIN Treatment t ON s.staff_ID = t.staff_ID
        WHERE s.organisation_ID = ? AND t.treatmentName LIKE ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // View a list of staff in an organisation, by gender
    function searchGender($keywords, $keywords2, $keywords3) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " s
        LEFT JOIN Organisation o ON s.organisation_ID = o.organisation_ID
        LEFT JOIN Treatment t ON t.staff_ID = s.staff_ID
        WHERE s.organisation_ID = ? AND s.genderName = ? AND t.treatmentName = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        $stmt->bindParam(3, $keywords3);
        // Execute query
        $stmt->execute();
        return $stmt;
    }
}
?>