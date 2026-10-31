<?php
// Security and Sanitization Helper Functions

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function enforce_method($expected_method) {
    if ($_SERVER['REQUEST_METHOD'] !== $expected_method) {
        http_response_code(405);
        echo json_encode([
            "status" => "error",
            "message" => "Method not allowed. Expected " . $expected_method
        ]);
        exit();
    }
}
?>
