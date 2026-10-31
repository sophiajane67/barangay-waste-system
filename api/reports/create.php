<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->resident_id) &&
    !empty($data->category_id) &&
    !empty($data->description) &&
    !empty($data->location)
) {
    // Generate a unique reference number
    $reference_no = "WR-" . strtoupper(substr(uniqid(), -6));

    $query = "INSERT INTO waste_reports (reference_no, resident_id, category_id, description, location, status) 
              VALUES (:reference_no, :resident_id, :category_id, :description, :location, 'Pending')";
    
    $stmt = $db->prepare($query);

    $stmt->bindParam(":reference_no", $reference_no);
    $stmt->bindParam(":resident_id", $data->resident_id);
    $stmt->bindParam(":category_id", $data->category_id);
    $stmt->bindParam(":description", $data->description);
    $stmt->bindParam(":location", $data->location);

    if($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Waste report submitted successfully!",
            "reference_no" => $reference_no
        ]);
    } else {
        http_response_code(503);
        echo json_encode(["status" => "error", "message" => "Unable to submit waste report."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Incomplete data. Please fill all required fields."]);
}
?>
