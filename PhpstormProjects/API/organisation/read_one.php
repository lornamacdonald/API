<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/organisation.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$organisation = new Organisation($db);

// Get keywords
$keywords = isset($_GET["organisation_ID"]) ? $_GET["organisation_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query organisations
$stmt = $organisation->readOne($keywords);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        // Organisation array
        $organisation_arr = array();
        $organisation_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $organisation_item = array(
                "name" => $name,
                "phone" => $phone,
                "email" => $email,
                "description" => $description,
                "typeName" => $typeName,
                "address" => $address,
                "town" => $town,
                "county" => $county,
                "postcode" => $postcode,
                "organisation_ID" => $organisation_ID,
                "openingTimes" => $openingTimes,
                "longitude" => $longitude,
                "latitude" => $latitude
            );
            array_push($organisation_arr["records"], $organisation_item);
        }
        echo json_encode($organisation_arr);
    } else {
        echo json_encode(
            array("message" => "Organisation not found.")
        );
    }
}
?>