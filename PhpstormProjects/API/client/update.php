<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/client.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$client = new Client($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Set values
$client->client_ID = $data->client_ID;
$client->phone = $data->phone;
$client->email = $data->email;
$client->password = $data->password;
$client->address = $data->address;
$client->town = $data->town;
$client->county = $data->county;
$client->postcode = $data->postcode;

if (password_verify('secret', $data->authorisation)) {

// Run the update method
    if ($client->update()) {
        echo '{';
        echo '"message": "Client has been updated."';
        echo '}';
    } else {
        echo '{';
        echo '"message": "Unable to update client."';
        echo '}';
    }
}
?>