<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/appointment.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$appointment = new Appointment($db);

// Get keywords
$keywords = isset($_GET["client_ID"]) ? $_GET["client_ID"] : "";
$keywords2 = isset($_GET["date"]) ? $_GET["date"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query aroducts
$stmt = $appointment->displayAppointmentsOnDate($keywords, $keywords2);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {
        // Appointment array
        $appointment_arr = array();
        $appointment_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $appointment_item = array(
                "date" => $date,
                "name" => $name,
                "typeName" => $typeName,
                "startTime" => $startTime,
                "endTime" => $endTime,
                "appointment_ID" => $appointment_ID,
                "dayOfWeek" => $dayOfWeek
            );
            array_push($appointment_arr["records"], $appointment_item);
        }
        echo json_encode($appointment_arr);
    } else {
        echo json_encode(
            array("message" => "You have no upcoming appointments. Visit an organisation's page to book with them.")
        );
    }
}
?>