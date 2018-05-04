<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/timeSlot.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$timeSlot = new TimeSlot($db);

// Get keywords
$keywords = isset($_GET["staff_ID"]) ? $_GET["staff_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query time slots
$stmt = $timeSlot->search($keywords);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        // TimeSlot array
        $timeSlot_arr = array();
        $timeSlot_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $timeSlot_item = array(
                "date" => $date,
                "staff_ID" => $staff_ID,
                "dayOfWeek" => $dayOfWeek
            );
            array_push($timeSlot_arr["records"], $timeSlot_item);
        }
        echo json_encode($timeSlot_arr);
    } else {
        echo json_encode(
            array("message" => "No times available.")
        );
    }
}
?>