<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/favourites.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$favourites = new Favourites($db);

// Get keywords
$keywords = isset($_GET["client_ID"]) ? $_GET["client_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query favourites
$stmt = $favourites->displayFavourites($keywords);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        // Favourites array
        $favourites_arr = array();
        $favourites_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $favourites_item = array(
                "name" => $name,
                "organisation_ID" => $organisation_ID
            );
            array_push($favourites_arr["records"], $favourites_item);
        }
        echo json_encode($favourites_arr);
    } else {
        echo json_encode(
            array("message" => "You have not favourited any organisations. Visit an organisation's page to favourite them.")
        );
    }
}
?>