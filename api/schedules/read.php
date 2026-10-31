<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT s.id, s.area_name, s.collection_day, s.collection_time, c.name AS category_name, s.status, s.created_at 
          FROM collection_schedules s 
          INNER JOIN waste_categories c ON s.category_id = c.id 
          ORDER BY FIELD(s.collection_day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), s.collection_time ASC";

$stmt = $db->prepare($query);
$stmt->execute();

$schedules = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($schedules, $row);
}

http_response_code(200);
echo json_encode([
    "status" => "success",
    "count" => count($schedules),
    "schedules" => $schedules
]);
?>
