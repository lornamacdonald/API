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
$keywords2 = isset($_GET["organisation_ID"]) ? $_GET["organisation_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query favourites
$stmt = $favourites->isFavourited($keywords, $keywords2);
$num = $stmt->rowCount();

// Favourites array
$favourites_arr = array();
$favourites_arr["records"] = array();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        $favourites_item = array(
            "value" => "1"
        );
        array_push($favourites_arr["records"], $favourites_item);
        echo json_encode($favourites_arr);
    } else {
        $favourites_item = array(
            "value" => "0"
        );
        array_push($favourites_arr["records"], $favourites_item);
        echo json_encode($favourites_arr);
    }
}
?>