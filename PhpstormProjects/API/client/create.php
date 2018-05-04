<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include database file and object file
include_once '../config/database.php';
include_once '../objects/client.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initalise object
$client = new Client($db);

// Get data
$data = json_decode(file_get_contents("php://input"));

// Set values
$client->firstName = $data->firstName;
$client->lastName = $data->lastName;
$client->genderName = $data->genderName;
$client->dob = $data->dob;
$client->phone = $data->phone;
$client->email = $data->email;
$client->password = $data->password;
$client->address = $data->address;
$client->town = $data->town;
$client->county = $data->county;
$client->postcode = $data->postcode;

if (password_verify('secret', $data->authorisation)) {

// Run the create method
    if ($client->create()) {
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
