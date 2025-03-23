<?php
header("Content-Type:application/json");
include '../functions/config.php';

function get_combined_customer_data($connect) {
    // Query to join the tables based on the common column 'user_id'
    $sql = "
        SELECT 
            d.*,
            a.*, -- Example column from kyc_cust_account_opening
            e.* -- Example column from kyc_cust_employment
        FROM kyc_cust_details d
        LEFT JOIN kyc_cust_account_opening a ON d.user_id = a.user_id
        LEFT JOIN kyc_cust_employment e ON d.user_id = e.user_id
    ";

    $stmt = $connect->query($sql);

    $data = [];
    while ($row = $stmt->fetch_assoc()) {          
        $data[] = $row;
    }

    return $data;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $customer_data = get_combined_customer_data($conn);
    echo json_encode(["status" => "success", "customers" => $customer_data]);
}

?>
