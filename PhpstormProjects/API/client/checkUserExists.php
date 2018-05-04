<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/client.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$client = new Client($db);

// Get keywords
$keywords = isset($_GET["email"]) ? $_GET["email"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query clients
$stmt = $client->checkUserExists($keywords);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Favourites array
    $client_arr = array();
    $client_arr["records"] = array();

// Check if more than 0 records were found
    if ($num > 0) {

        $client_item = array(
            "value" => "1"
        );
        array_push($client_arr["records"], $client_item);
        echo json_encode($client_arr);
    } else {
        $client_item = array(
            "value" => "0"
        );
        array_push($client_arr["records"], $client_item);
        echo json_encode($client_arr);
    }
}
?>