<?php 
header("Content-Type:application/json");
include '../functions/config.php';

function get_customer_data($connect, $placement) {
    $sql = "
            SELECT
            c.id AS customer_id, 
            c.email AS customer_email, 
            d.*, 
            a.*,
            b.*,
            e.*
        FROM kyc_customers c
        LEFT JOIN kyc_cust_details d ON c.id = d.user_id
        LEFT JOIN kyc_cust_account_opening a ON c.id = a.user_id
        LEFT JOIN kyc_cust_employment e ON c.id = e.user_id
        LEFT JOIN applications b ON c.id = b.user_id WHERE b.bank_id = ?
        ";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $placement);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = [];
    
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt->close();

    return $data;
}

function get_compliance_data($connect) {
    $sql = "SELECT b.name AS bank_name, c.* FROM kyc_compliance c LEFT JOIN banks b ON b.id = c.Placement";
    $stmt = $connect->query($sql);

    $data = [];
    while ($row = $stmt->fetch_assoc()) {          
        $data[] = $row;  
    } 
    $response = [];
    $response['data'] =  $data;

    return $response;
}

function update_user_status($connect, $userId, $status) {
    $sql = "UPDATE applications SET status = ? WHERE user_id = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("si", $status, $userId);

    if ($stmt->execute()) {
        return ["status" => "success", "message" => "User status updated successfully"];
    } else {
        return ["status" => "error", "message" => "Failed to update user status"];
    }
}

function get_user_by_id($connect, $userId) {
    $sql = "
            SELECT
            c.id AS customer_id, 
            c.email AS customer_email, 
            d.*, 
            a.*,
            b.*,
            e.*
        FROM kyc_customers c
        LEFT JOIN kyc_cust_details d ON c.id = d.user_id
        LEFT JOIN kyc_cust_account_opening a ON c.id = a.user_id
        LEFT JOIN kyc_cust_employment e ON c.id = e.user_id
        LEFT JOIN applications b ON c.id = b.user_id WHERE c.id = ?
        ";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        return ["status" => "success", "user" => $user];
    } else {
        return ["status" => "error", "message" => "User not found"];
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $level = $_GET['level'];
    if ($level === 'compliance' && isset($_GET['placement'])) {
        echo json_encode(["status" => "success", "customers" => get_customer_data($conn,  intval($_GET['placement'])), "compliance" => get_compliance_data($conn)]);
    } elseif ($level === 'user' && isset($_GET['id'])) {
        $userId = intval($_GET['id']);
        echo json_encode(get_user_by_id($conn, $userId));
    }
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['id']) && isset($input['status'])) {
        $userId = intval($input['id']);
        $status = $input['status'];
        echo json_encode(update_user_status($conn, $userId, $status));
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input data"]);
    }
}
?>
