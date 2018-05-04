<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database file and object file
include_once '../config/database.php';
include_once '../objects/favourites.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initalise object
$favourites = new Favourites($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Set values
$favourites->client_ID = $data->client_ID;
$favourites->organisation_ID = $data->organisation_ID;

if (password_verify('secret', $data->authorisation)) {

// Run the create method
    if ($favourites->create()) {
        echo '{';
        echo '"message": "Your account has been created."';
        echo '}';
    } else {
        echo '{';
        echo '"message": "Unable to create your account."';
        echo '}';
    }
}
?>