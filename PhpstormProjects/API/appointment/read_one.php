<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/appointment.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object object
$appointment = new Appointment($db);

// Get keywords
$keywords = isset($_GET["appointment_ID"]) ? $_GET["appointment_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

if (password_verify('secret', $authorisation)) {

// Query appointments
    $stmt = $appointment->readOne($keywords);
    $num = $stmt->rowCount();

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
                "startTime" => $startTime,
                "endTime" => $endTime,
                "name" => $name,
                "treatmentName" => $treatmentName,
                "title" => $title,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "appointment_ID" => $appointment_ID,
                "organisation_ID" => $organisation_ID,
                "client_ID" => $client_ID,
                "dayOfWeek" => $dayOfWeek,
                "timeSlot_ID" => $timeSlot_ID
            );
            array_push($appointment_arr["records"], $appointment_item);
        }
        echo json_encode($appointment_arr);
    } else {
        echo json_encode(
            array("message" => "Appointment not found.")
        );
    }
}
?>