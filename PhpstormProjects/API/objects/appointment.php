<?php
class Appointment
{

    // Database connection and table name
    private $conn;
    private $table_name = "Appointment";

    // Constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // View a single appointment
    function readOne($keywords) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " a
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        LEFT JOIN Treatment r ON a.treatment_ID = r.treatment_ID
          LEFT JOIN StaffMember s ON r.staff_ID = s.staff_ID
          LEFT JOIN Organisation o ON s.organisation_ID = o.organisation_ID
          WHERE a.appointment_ID = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }



    // View a list of upcoming appointments, in short form
    function displayUpcomingAppointments($keywords) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " a
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        LEFT JOIN Organisation o ON o.organisation_ID = s.organisation_ID
        LEFT JOIN Client c ON a.client_ID = c.client_ID
        WHERE a.client_ID = ? AND t.date > NOW()
        ORDER BY t.date, t.startTime ASC";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // sanitize
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Get the user's next appointment
    function nextAppointment($keywords) {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " a
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        LEFT JOIN Organisation o ON o.organisation_ID = s.organisation_ID
        LEFT JOIN Client c ON a.client_ID = c.client_ID
        WHERE a.client_ID = ? AND t.date > NOW()
        ORDER BY t.date, t.startTime ASC
        LIMIT 1";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // sanitize
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }


    // View a list of appointments on a selected date, in short form
    function displayAppointmentsOnDate($keywords, $keywords2)
    {
        // SQL query
        $query = "SELECT * FROM " . $this->table_name . " a
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        LEFT JOIN Organisation o ON s.organisation_ID = o.organisation_ID
        WHERE a.client_ID = ? AND t.date = ?
        ORDER BY t.startTime ASC";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Display all calendar dates
    function displayCalendarDates($keywords) {
        // SQL query
        $query = "SELECT DISTINCT t.date, o.name, o.typeName, t.dayOfWeek FROM " . $this->table_name . " a
        LEFT JOIN Client c ON a.client_ID = a.client_ID
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        LEFT JOIN Organisation o ON o.organisation_ID = s.organisation_ID
        WHERE a.client_ID = ?
        ORDER BY t.date DESC";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Display all calendar dates in a month
    function displayCalendarDatesSearch($keywords, $keywords2) {
        // SQL query
        $query = "SELECT DISTINCT t.date, o.name, o.typeName, t.dayOfWeek FROM " . $this->table_name . " a
        LEFT JOIN Client c ON a.client_ID = a.client_ID
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        LEFT JOIN Organisation o ON o.organisation_ID = s.organisation_ID
        WHERE a.client_ID = ? AND MONTH(t.date) = ?
        ORDER BY t.date DESC";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Delete an appointment
    function delete($keywords)
    {
        // SQL query
        $query = "DELETE FROM " . $this->table_name . "
        WHERE appointment_ID = ?";
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

    // Delete all user's appointments
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

    // Determine if a user can make an appointment on that date
    function canBook($keywords, $keywords2) {
        // SQl query
        $query = "SELECT * FROM Appointment a
        LEFT JOIN Treatment t ON a.treatment_ID = t.treatment_ID
        LEFT JOIN StaffMember s ON s.staff_ID = t.staff_ID
        LEFT JOIN Organisation o ON o.organisation_ID = s.organisation_ID
        WHERE a.client_ID = ? AND o.organisation_ID = ? AND a.dateCreated = CURDATE()";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // List the number of appointments on a date
    function numberOfAppointments($keywords, $keywords2) {
        // SQl query
        $query = "SELECT * FROM Appointment a
        LEFT JOIN TimeSlot t ON a.timeSlot_ID = t.timeSlot_ID
        WHERE a.client_ID = ? AND t.date = ?";
        // Prepare query statement
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords2);
        // Execute query
        $stmt->execute();
        return $stmt;
    }

    // Create an appointment
    function create() {
        // SQL query
        $query = "INSERT INTO " . $this->table_name . "
        SET client_ID=:client_ID, timeSlot_ID=:timeSlot_ID, treatment_ID=:treatment_ID, dateCreated=:dateCreated";
        // Prepare query
        $stmt = $this->conn->prepare($query);
        // Bind
        $stmt->bindParam(":client_ID", $this->client_ID);
        $stmt->bindParam(":timeSlot_ID", $this->timeSlot_ID);
        $stmt->bindParam(":treatment_ID", $this->treatment_ID);
        $stmt->bindParam(":dateCreated", $this->dateCreated);
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>