<?php
include '../functions/config.php'; // Include database configuration

// Handle the request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET' && isset($_GET['user_id'])) {
    // Fetch all applications for the user (any status)
    $user_id = (int)$_GET['user_id'];
    $sql = "SELECT bank_id FROM applications WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($data);
    $stmt->close();
}

 elseif ($method === 'POST') {
    // Read the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    $user_id = $data['user_id'] ?? null;
    $bank_id = $data['bank_id'] ?? null;
    $status = 'To Review'; // Always set status to "To Review"
    $submitted_at = $data['submitted_at'] ?? date('Y-m-d H:i:s');

    if (!$user_id || !$bank_id) {
        http_response_code(400);
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }

    // Insert into the `applications` table
    $sql = "INSERT INTO applications (user_id, bank_id, status, submitted_at) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiss', $user_id, $bank_id, $status, $submitted_at);

    if ($stmt->execute()) {
        echo json_encode(['message' => 'Application submitted successfully']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Failed to submit the application']);
    }

    $stmt->close();
}else {
    // Fetch all banks
    $sql = "SELECT id, name FROM banks";
    $result = $conn->query($sql);

    $data = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);
}


// Close the connection
$conn->close();
?>
