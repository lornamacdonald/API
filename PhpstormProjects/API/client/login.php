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
$keywords2 = isset($_GET["password"]) ? $_GET["password"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query clients
$stmt = $client->login($keywords, $keywords2);
$num = $stmt->rowCount();

// Favourites array
$client_arr = array();
$client_arr["records"] = array();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {
        // Appointment array
        $client_arr = array();
        $client_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $client_item = array(
                "client_ID" => $client_ID
            );
            array_push($client_arr["records"], $client_item);
        }
        echo json_encode($client_arr);
    } else {
        $client_item = array(
            "client_ID" => "0"
        );
        array_push($client_arr["records"], $client_item);
        echo json_encode($client_arr);
    }
}
?>