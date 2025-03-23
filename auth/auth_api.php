<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

if($_SERVER["REQUEST_METHOD"] === "GET"){
    $email = $_GET['email'] ?? null;
    $password = $_GET['password'] ?? null;
    $purpose = $_GET['for'];
    
    if($email && $password && $purpose === "login"){
        $authURL = "{$_SERVER['SERVER_NAME']}/kyc/auth/auth.php?email=" . urlencode($email) . "&password=" . urlencode($password);

        $ch = curl_init($authURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo json_encode([
                "status" => "error",
                "message" => "Error connecting to auth.php",
                "details" => curl_error($ch)
            ]);
        } else {
            // Return the response from the other PHP file
            http_response_code($httpCode);
            echo $response;
        }

        curl_close($ch);
    } else {
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        http_response_code(400);
    }
} elseif($_SERVER["REQUEST_METHOD"] === "POST"){
    $data = json_decode(file_get_contents("php://input"), true);

    if($data['email'] && $data['password']){
        $data = array("email"=>$data['email'],"password"=>$data['password']);

        $authURL = "{$_SERVER['SERVER_NAME']}/kyc/auth/auth.php";

        $ch = curl_init($authURL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            echo json_encode([
                "status" => "error",
                "message" => "Error connecting to auth.php",
                "details" => curl_error($ch)
            ]);
        } else {
            // Return the response from the other PHP file
            http_response_code($httpCode);
            echo $response;
        }

        curl_close($ch);
    } else{
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        http_response_code(400);
    }
    
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    http_response_code(405);
}