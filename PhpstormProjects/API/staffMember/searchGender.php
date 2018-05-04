<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Include database and object files
include_once '../config/database.php';
include_once '../objects/staffMember.php';

// Get database connection
$database = new Database();
$db = $database->getConnection();

// Initialise object
$staffMember = new StaffMember($db);

// Get keywords
$keywords = isset($_GET["organisation_ID"]) ? $_GET["organisation_ID"] : "";
$keywords2 = isset($_GET["genderName"]) ? $_GET["genderName"] : "";
$keywords3 = isset($_GET["treatmentName"]) ? $_GET["treatmentName"] : "";
$authorisation = isset($_GET["authorisation"]) ? $_GET["authorisation"] : "";

// Query staff members
$stmt = $staffMember->searchGender($keywords, $keywords2, $keywords3);
$num = $stmt->rowCount();

if (password_verify('secret', $authorisation)) {

// Check if more than 0 records were found
    if ($num > 0) {

        // StaffMember array
        $staffMember_arr = array();
        $staffMember_arr["records"] = array();

        // Retrieve table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Extract row (make $row['name'] to just $name only)
            extract($row);

            $staffMember_item = array(
                "staff_ID" => $staff_ID,
                "organisation_ID" => $organisation_ID,
                "title" => $title,
                "firstName" => $firstName,
                "lastName" => $lastName,
                "genderName" => $genderName
            );
            array_push($staffMember_arr["records"], $staffMember_item);
        }
        echo json_encode($staffMember_arr);
    } else {
        echo json_encode(
            array("message" => "No staff member found.")
        );
    }
}
?>