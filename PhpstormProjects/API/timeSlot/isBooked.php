<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object file
include_once '../config/database.php';
include_once '../objects/timeSlot.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$timeSlot = new TimeSlot($db);

// Get keywords
$keywords = isset($_GET["timeSlot_ID"]) ? $_GET["timeSlot_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

if (password_verify('secret', $authorisation)) {

// Run the delete method
    if ($timeSlot->isBooked($keywords)) {
        echo '{';
        echo '"message": "Appointment has been created."';
        echo '}';
    } else {
        echo '{';
        echo '"message": "Unable to create appointment."';
        echo '}';
    }
}
?>