<?php
session_start();

include './functions/config.php';

// Ensure the 'email' cookie exists
if (!isset($_COOKIE['email'])) {
    die('Error: Email cookie not set.');
}

$email = $_COOKIE['email'];
echo "Processing your login...";

$sql = "SELECT email, user_type FROM kyc_users WHERE email = ?";
$stmt = $conn->stmt_init();
if ($stmt->prepare($sql)) {
    $stmt->bind_param('s', $email);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            if ($data['user_type'] === 'customer') {
                $sql = "SELECT a.*, b.* FROM kyc_users a INNER JOIN kyc_customers b ON a.email = b.email WHERE a.email = ?";
                if ($stmt->prepare($sql)) {
                    $stmt->bind_param('s', $email);
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $data = $result->fetch_assoc();

                        if ($data) {
                            $_SESSION['user_id'] = $data['id'];
                            $_SESSION['email'] = $data['email'];
                            header('Location: ./user/user_dashboard.php');
                            exit;
                        }
                    }
                }
            } elseif ($data['user_type'] === 'compliance') {
                $sql = "SELECT a.*, b.* FROM kyc_users a INNER JOIN kyc_compliance b ON a.email = b.Email WHERE a.email = ?";
                if ($stmt->prepare($sql)) {
                    $stmt->bind_param('s', $email);
                    if ($stmt->execute()) {
                        $result = $stmt->get_result();
                        $data = $result->fetch_assoc();

                        if ($data) {
                            $_SESSION['placement'] = $data['Placement'];
                            $_SESSION['email'] = $data['Email'];
                            $_SESSION['user_id'] = $data['id'];
                            header('Location: ./compliance/user_rev_dashboard.php');
                            exit;
                        }
                    }
                }
            } else {
                die('Error: Unknown user type.');
            }
        } else {
            die('Error: User not found.');
        }
    } else {
        die('Error: Query execution failed.');
    }
} else {
    die('Error: Query preparation failed.');
}
?>
