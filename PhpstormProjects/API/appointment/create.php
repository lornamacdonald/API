<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object file
include_once '../config/database.php';
include_once '../objects/appointment.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$appointment = new Appointment($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Set values
$appointment->client_ID = $data->client_ID;
$appointment->timeSlot_ID = $data->timeSlot_ID;
$appointment->treatment_ID = $data->treatment_ID;
$appointment->dateCreated = date("Y-m-d");

if (password_verify('secret', $data->authorisation)) {

    // Run the create method
    if ($appointment->create()) {
        echo '{';
        echo '"message": "Appointment has been created."';
        echo '}';
    }
    else {
        echo '{';
        echo '"message": "Unable to create appointment."';
        echo '}';
    }
}
?>


