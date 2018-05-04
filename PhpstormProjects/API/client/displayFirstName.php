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
$keywords = isset($_GET["client_ID"]) ? $_GET["client_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query clients
$stmt = $client->displayFirstName($keywords);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        // Client array
        $client_arr = array();
        $client_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $client_item = array(
                "firstName" => $firstName
            );
            array_push($client_arr["records"], $client_item);
        }
        echo json_encode($client_arr);
    } else {
        echo json_encode(
            array("message" => "Client not found.")
        );
    }
}
?>