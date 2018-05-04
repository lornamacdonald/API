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
$keywords2 = isset($_GET["organisation_ID"]) ? $_GET["organisation_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query favourites
$stmt = $appointment->canBook($keywords, $keywords2);
$num = $stmt->rowCount();

// Favourites array
$appointment_arr = array();
$appointment_arr["records"] = array();

if (password_verify('secret', $authorisation)) {
    // Check if more than 0 records were found
    if ($num > 0) {

        $appointment_item = array(
            "value" => "false"
        );
        array_push($appointment_arr["records"], $appointment_item);
        echo json_encode($appointment_arr);
    }
    else {
        $appointment_item = array(
            "value" => "true"
        );
        array_push($appointment_arr["records"], $appointment_item);
        echo json_encode($appointment_arr);
    }
}
?>