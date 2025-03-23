<?php
header("Content-Type:application/json");
include '../functions/config.php';

// Function to sanitize input strings
function sanitize_input($input) {
    return isset($input) && trim($input) !== '' ? htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8') : null;
}
function handleFileUpload($file, $user_id, $upload_dir, $file_type) {
    if (isset($file) && $file["error"] === UPLOAD_ERR_OK) {
        $tmp_name = $file["tmp_name"];
        $file_name = $file["name"];

        // Check if the uploaded file is an image
        $image_type = exif_imagetype($tmp_name);
        if (!$image_type) {
            die("File '$file_type' is not a valid image.");
        }

        // Check file size (max 2 MB)
        if ($file["size"] > 2 * 1024 * 1024) {
            die("File '$file_type' exceeds the size limit of 2 MB.");
        }

        // Get the file extension
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // Define the new file name based on file type
        $new_file_name = $user_id . "_" . $file_type . "." . $file_extension;
        $upload_path = $upload_dir . $new_file_name;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp_name, $upload_path)) {
            echo "File '$file_type' uploaded successfully: " . $new_file_name . "<br>";
        } else {
            die("Failed to move file '$file_type'.");
        }
    } else {
        die("File '$file_type' upload error or no file uploaded.");
    }
}
// Function to fetch API data
function fetch_api_data($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Disable SSL host verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL peer verification
    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch) . PHP_EOL;
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "JSON decode error: " . json_last_error_msg() . PHP_EOL;
        return null;
    }

    return $data;
}

// Function to map ID to name
function map_id_to_name($id, $data) {
    foreach ($data as $item) {
        if ($item['id'] == $id) {
            return $item['name'];
        }
    }
    return null;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"];
    $upload_dir = "user_file/" . $user_id . "/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Handle the first file upload (KTP)
    handleFileUpload($_FILES["img_upload1"], $user_id, $upload_dir, "ktp");

    // Handle the second file upload (KK)
    handleFileUpload($_FILES["img_upload2"], $user_id, $upload_dir, "kk");
    // Ensure the upload directory exists

    // Sanitize and store POST data
    $user_id = sanitize_input($_POST['user_id']);
    $ktp_number = sanitize_input($_POST['ktpnum'] ?? null);
    $first_name = sanitize_input($_POST['fname'] ?? null);
    $last_name = sanitize_input($_POST['lname'] ?? null);
    $mother_maiden_name = sanitize_input($_POST['maiden_name'] ?? null);
    $gender = sanitize_input($_POST['gender'] ?? null);
    $religion = sanitize_input($_POST['religion'] ?? null);
    $education = sanitize_input($_POST['education'] ?? null);
    $date_of_birth = sanitize_input($_POST['dob'] ?? null);
    $place_of_birth = sanitize_input($_POST['place_dob'] ?? null);
    $phone_number = sanitize_input($_POST['phone_num'] ?? null);
    $marital_status = sanitize_input($_POST['marital_status'] ?? null);

    // Convert numeric IDs to names
    $province_id = sanitize_input($_POST['province'] ?? null);
    $regency_id = sanitize_input($_POST['regency'] ?? null);
    $district_id = sanitize_input($_POST['district'] ?? null);

    // Fetch province name
    $provinces = fetch_api_data('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
    $province = map_id_to_name($province_id, $provinces);

    // Fetch regency name
    $regency_url = "https://www.emsifa.com/api-wilayah-indonesia/api/regencies/{$province_id}.json";
    $regencies = fetch_api_data($regency_url);
    $regency_city = map_id_to_name($regency_id, $regencies);

    // Fetch district name
    $district_url = "https://www.emsifa.com/api-wilayah-indonesia/api/districts/{$regency_id}.json";
    $districts = fetch_api_data($district_url);
    $district = map_id_to_name($district_id, $districts);

    $post_code = sanitize_input($_POST['post_code'] ?? null);
    $address = sanitize_input($_POST['address'] ?? null);
    $residence_status = sanitize_input($_POST['residence'] ?? null);
    $mailing_address = sanitize_input($_POST['mailing'] ?? null);

    // Insert into personal_details table
    $stmt = $conn->prepare(
        "INSERT INTO kyc_cust_details (
            user_id, ktp_number, first_name, last_name, mother_maiden_name, gender, religion, education,
            date_of_birth, place_of_birth, phone_number, marital_status, province, regency_city,
            district, post_code, address, residence_status, mailing_address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "issssssssssssssssss",
        $user_id, $ktp_number, $first_name, $last_name, $mother_maiden_name, $gender, $religion, $education,
        $date_of_birth, $place_of_birth, $phone_number, $marital_status, $province, $regency_city,
        $district, $post_code, $address, $residence_status, $mailing_address
    );
    $stmt->execute();

    // Process the data (example: save to database, log, or output)
    // Get employment details
    $current_job = sanitize_input($_POST['current_job'] ?? null);
    $job_status = sanitize_input($_POST['job_status'] ?? null);
    $company_name = sanitize_input($_POST['company'] ?? null);
    $business_sector = sanitize_input($_POST['business_sector'] ?? null);
    $start_working_date = sanitize_input($_POST['date_start_work'] ?? null);
    $position = sanitize_input($_POST['job_position'] ?? null);

    // Insert into employment_details table
    $stmt = $conn->prepare(
        "INSERT INTO kyc_cust_employment (
            user_id, current_job, job_status, company_name, business_sector, start_working_date, position
        ) VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param(
        "issssss",
        $user_id, $current_job, $job_status, $company_name, $business_sector, $start_working_date, $position
    );
    $stmt->execute();

    // Get account opening details
    $account_type = sanitize_input($_POST['acc_type'] ?? null);
    $purpose = sanitize_input($_POST['purpose'] ?? null);

    // Insert into account_opening table
    $stmt = $conn->prepare(
        "INSERT INTO kyc_cust_account_opening (
            user_id, account_type, purpose
        ) VALUES (?, ?, ?)"
    );
    $stmt->bind_param(
        "iss",
        $user_id, $account_type, $purpose
    );
    $stmt->execute();

    // Close connections
    $stmt->close();
    $conn->close();

    echo "<script>alert('Success!'></script>";
    header('Location: ./user_dashboard.php');

} else {
    echo json_encode(["status" => "Error!"]);
}
?>
