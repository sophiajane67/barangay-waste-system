<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->area_name) &&
    !empty($data->collection_day) &&
    !empty($data->collection_time) &&
    !empty($data->category_id)
) {
    $query = "INSERT INTO collection_schedules (area_name, collection_day, collection_time, category_id, status) 
              VALUES (:area_name, :collection_day, :collection_time, :category_id, 'Active')";
    
    $stmt = $db->prepare($query);

    $stmt->bindParam(":area_name", $data->area_name);
    $stmt->bindParam(":collection_day", $data->collection_day);
    $stmt->bindParam(":collection_time", $data->collection_time);
    $stmt->bindParam(":category_id", $data->category_id);

    if($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Collection schedule added successfully!"
        ]);
    } else {
        http_response_code(503);
        echo json_encode(["status" => "error", "message" => "Unable to create schedule."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Incomplete data. Please fill all fields."]);
}
?>
