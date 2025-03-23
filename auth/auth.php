<?php

include '../functions/config.php';

// Ensure the request method is GET
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $email = $_GET['email'] ?? null;
    $pass = $_GET['password'] ?? null;
    
    if ($email && $pass) {
        // Dummy logic for user validation

        $result = $conn->query("SELECT email,password FROM kyc_users WHERE email = '$email' AND password = '$pass'");
        if ($result->num_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Login success"]);
        } else {
            echo json_encode(["status" => "fail", "message" => "Invalid credentials"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Email and password are required"]);
        http_response_code(400);
    }
} elseif($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? null;
    $pass = $_POST['password'] ?? null;

    if($email && $pass){
        $row_check = $conn->query("SELECT email FROM kyc_users WHERE email = '$email'");
        if($row_check->num_rows > 0){
            echo json_encode(["status" => "fail", "message" => "Email is already registered!"]);
        } else{
            $sql = "INSERT INTO kyc_users (email,password,user_type) VALUES (?,?,'customer');";
            $stmt = $conn->stmt_init();
            $stmt->prepare($sql);

            $stmt->bind_param('ss', $email,$pass);
            if($stmt->execute()){
                $sql2 = "INSERT INTO kyc_customers (email) VALUES (?)";
                $stmt = $conn->stmt_init();
                $stmt->prepare($sql2);
                $stmt->bind_param('s', $email);
                if($stmt->execute()){
                    echo json_encode(["status" => "success", "message" => "User has been registered"]);}
            } else {
                echo json_encode(["status" => "fail", "message" => "Bad Email/Password"]);
            }
        }
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
    http_response_code(405);
}
