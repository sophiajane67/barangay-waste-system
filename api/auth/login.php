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

if(!empty($data->email) && !empty($data->password)) {
    $email = sanitize_input($data->email);
    $password = $data->password; // Password verified via password_verify, do not HTML sanitize raw password prior to check

    $query = "SELECT id, full_name, email, password, role, status FROM users WHERE email = :email LIMIT 0,1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($password, $row['password'])) {
            if($row['status'] === 'Active') {
                http_response_code(200);
                echo json_encode([
                    "status" => "success",
                    "message" => "Login successful.",
                    "user" => [
                        "id" => $row['id'],
                        "full_name" => $row['full_name'],
                        "email" => $row['email'],
                        "role" => $row['role']
                    ]
                ]);
            } else {
                http_response_code(403);
                echo json_encode(["status" => "error", "message" => "Account is pending admin approval or suspended."]);
            }
        } else {
            http_response_code(401);
            echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
        }
    } else {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Invalid email or password."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Incomplete login credentials."]);
}
?>
