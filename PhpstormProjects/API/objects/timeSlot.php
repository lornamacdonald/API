<?php
class TimeSlot {

    // Database connection and table name
    private $conn;
    private $table_name = "TimeSlot";

    // Constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // View a list of all dates a staff member is free
    function search($keywords) {
        // SQL query
        $query = "SELECT DISTINCT t.date, t.staff_ID, t.dayOfWeek FROM " . $this->table_name . " t
        WHERE t.staff_ID = ? AND t.isBooked = 0 AND t.date >= CURDATE()
        ORDER BY t.date";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // View a list of all dates a staff member is free, in a month
    function searchMonth($keywords, $keywords2) {
        // SQL query
        $query = "SELECT DISTINCT t.date, t.dayOfWeek FROM " . $this->table_name . " t
        WHERE t.staff_ID = ? AND t.isBooked = 0 AND MONTH(t.date) >= MONTH(CURDATE()) AND MONTH(t.date) = ? AND t.date >= CURDATE()
        ORDER BY t.date";

        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }


    // View a list of time slots that a staff member is free, on a specific date
    function displayFreeSlots($keywords, $keywords2) {
        // SQL query
        $query = "SELECT DISTINCT t.startTime, t.endTime, t.staff_ID, t.dayOfWeek FROM " . $this->table_name . " t
        WHERE t.staff_ID = ? AND t.date = ? AND t.isBooked = 0 AND t.date > CURDATE()
        ORDER BY t.startTime";


        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // View the next available time slot that a staff member is free
    function nextAvailable($keywords) {
        // SQL query
        $query = "SELECT t.date, t.startTime, t.endTime, t.dayOfWeek FROM " . $this->table_name . " t
        WHERE (t.staff_ID = ? AND t.isBooked = 0 AND t.date > CURDATE())
        ORDER BY ABS(DATEDIFF(t.date, CURDATE())), t.startTime
        LIMIT 1";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Make a time slot booked
    function isBooked($keywords) {
        // SQL query
        $query = "UPDATE " . $this->table_name . " SET isBooked = 1 WHERE timeSlot_ID=?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Make a time slot free
    function notBooked($keywords) {
        // SQL query
        $query = "UPDATE " . $this->table_name . " SET isBooked = 0 WHERE timeSlot_ID=?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get a time slot
    function getTimeSlot($keywords, $keywords2, $keywords3, $keywords4) {
        $query = "SELECT timeSlot_ID FROM " . $this->table_name . "
                  WHERE staff_ID = ? AND startTime = ? AND endTime = ? AND date = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        $stmt->bindParam(3, $keywords3);
        $stmt->bindParam(4, $keywords4);

        // Execute query
        $stmt->execute();
        return $stmt;
    }

}
?>