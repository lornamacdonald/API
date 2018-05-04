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

// Get keywords
$keywords = isset($_GET["appointment_ID"]) ? $_GET["appointment_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

if (password_verify('secret', $authorisation)) {

// Run the delete method
    if ($appointment->delete($keywords)) {
        echo '{';
        echo '"message": "Appointment has been deleted."';
        echo '}';
    } else {
        echo '{';
        echo '"message": "Unable to delete appointment."';
        echo '}';
    }
}
?>