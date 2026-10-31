<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$resident_id = isset($_GET['resident_id']) ? $_GET['resident_id'] : null;

$query = "SELECT r.id, r.reference_no, u.full_name AS resident_name, c.name AS category_name, 
                 r.description, r.location, r.photo_path, r.status, r.created_at 
          FROM waste_reports r 
          INNER JOIN users u ON r.resident_id = u.id 
          INNER JOIN waste_categories c ON r.category_id = c.id";

if($resident_id) {
    $query .= " WHERE r.resident_id = :resident_id";
}

$query .= " ORDER BY r.created_at DESC";

$stmt = $db->prepare($query);

if($resident_id) {
    $stmt->bindParam(":resident_id", $resident_id);
}

$stmt->execute();

$reports = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    array_push($reports, $row);
}

http_response_code(200);
echo json_encode([
    "status" => "success",
    "count" => count($reports),
    "reports" => $reports
]);
?>
