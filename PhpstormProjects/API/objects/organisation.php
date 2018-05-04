<?php
class Organisation {

    // Database connection and table name
    private $conn;
    private $table_name = "Organisation";

    // Constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // View an organisation
    function readOne($keywords) {
        // SQL query
        $query = "SELECT *
                  FROM " . $this->table_name . " o
                  LEFT JOIN OrganisationType t ON o.typeName = t.typeName
                  WHERE o.organisation_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // View a list of organisations, whose name or type match the query
    function search($keywords) {
        // select all query
        $query = "SELECT * FROM " . $this->table_name . " o
        LEFT JOIN OrganisationType t ON o.typeName = t.typeName
        WHERE o.name LIKE ? OR o.typeName LIKE ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }
}
?>