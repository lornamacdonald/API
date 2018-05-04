<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/treatment.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$treatment = new Treatment($db);

// Get keywords
$keywords = isset($_GET["organisation_ID"]) ? $_GET["organisation_ID"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query treatments
$stmt = $treatment->search($keywords);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        // Treatment array
        $treatment_arr = array();
        $treatment_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $treatment_item = array(
                "treatmentName" => $treatmentName,
                "organisation_ID" => $organisation_ID,
                "name" => $name
            );
            array_push($treatment_arr["records"], $treatment_item);
        }
        echo json_encode($treatment_arr);
    } else {
        echo json_encode(
            array("message" => "No treatments found.")
        );
    }
}
?>