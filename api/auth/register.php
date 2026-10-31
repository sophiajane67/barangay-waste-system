<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../config/security.php';

enforce_method('POST');

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(
    !empty($data->full_name) &&
    !empty($data->email) &&
    !empty($data->phone) &&
    !empty($data->address) &&
    !empty($data->password)
) {
    $full_name = sanitize_input($data->full_name);
    $email = sanitize_input($data->email);
    $phone = sanitize_input($data->phone);
    $address = sanitize_input($data->address);
    $password_hash = password_hash($data->password, PASSWORD_BCRYPT);

    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(":email", $email);
    $check_stmt->execute();

    if($check_stmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode(["status" => "error", "message" => "Email address is already registered."]);
        exit();
    }

    $query = "INSERT INTO users (full_name, email, phone, address, password, role, status) 
              VALUES (:full_name, :email, :phone, :address, :password, 'resident', 'Pending')";
    
    $stmt = $db->prepare($query);

    $stmt->bindParam(":full_name", $full_name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":phone", $phone);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":password", $password_hash);

    if($stmt->execute()) {
        http_response_code(201);
        echo json_encode([
            "status" => "success",
            "message" => "Registration submitted successfully! Please wait for admin approval."
        ]);
    } else {
        http_response_code(503);
        echo json_encode(["status" => "error", "message" => "Unable to register account."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Incomplete registration data."]);
}
?>
