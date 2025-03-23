<?php
session_start();
if(!isset($_SESSION['placement'])){
    header('Location: ../login.php');
  }
require('../fpdf/fpdf.php'); // Include FPDF library
$placement = $_SESSION['placement'];
$user_id = $_POST["user_id"];


$authURL = "{$_SERVER['SERVER_NAME']}/kyc/compliance/c_backend.php?level=compliance&placement=$placement";

$ch = curl_init($authURL);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

$x = json_decode($output,true);

function user_profile($data, $defined, $target_var) {
    foreach ($data["customers"] as $y) {
        if ($y['user_id'] == $defined) {
            return $y[$target_var] ?? '-';
        }
    }
    return '-';
}

function image_exist($uid, $type) {
    // Base directory and file name
    $baseDir = '../user//user_file/' . $uid . '/';
    $baseFile = $baseDir . $uid . '_' . $type;

    // Possible file extensions
    $extensions = ['.png', '.jpg', '.jpeg', '.gif'];

    // Check each extension
    foreach ($extensions as $ext) {
        $file = $baseFile . $ext;
        if (file_exists($file)) {
            return $file; // Return the file if it exists
        }
    }

    // Return a default placeholder if no image found
    return '../asset/default_' . $type . '.png';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Create instance of the FPDF class
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);

    // Add Title
    $pdf->Cell(0, 10, 'Customer Profile', 0, 1, 'C');
    $pdf->Ln(10);

    // Add Profile Picture
    $profile_picture = image_exist($user_id, 'pp');
    if ($profile_picture !== '-') {
        $pdf->Image($profile_picture, 10, 20, 40, 40); // X, Y, Width, Height
        $pdf->Ln(50); // Add space below the picture
    }

    // Add KTP Image
    $ktp_image = image_exist($user_id, 'ktp');
    if ($ktp_image !== '-') {
        $pdf->Image($ktp_image, 10, 70, 80, 40); // Adjust position and size as needed
        $pdf->Ln(30); // Add space below the picture
    }
    // Add KTP Image
    $ktp_image = image_exist($user_id, 'kk');
    if ($ktp_image !== '-') {
        $pdf->Image($ktp_image, 100, 70, 80, 40); // Adjust position and size as needed
    }
    // Fetch and format the details
    $details = [
        'Personal Details' => [
            'KTP Number' => user_profile($x, $user_id, 'ktp_number'),
            'First Name' => user_profile($x, $user_id, 'first_name'),
            'Last Name' => user_profile($x, $user_id, 'last_name'),
            'Gender' => user_profile($x, $user_id, 'gender'),
            'Religion' => user_profile($x, $user_id, 'religion'),
            'Education' => user_profile($x, $user_id, 'education'),
            'Date of Birth' => user_profile($x, $user_id, 'date_of_birth'),
            'Place of Birth' => user_profile($x, $user_id, 'place_of_birth'),
            'Phone Number' => user_profile($x, $user_id, 'phone_number'),
            'Marital Status' => user_profile($x, $user_id, 'marital_status'),
            'Province' => user_profile($x, $user_id, 'province'),
            'Regency/City' => user_profile($x, $user_id, 'regency_city'),
            'District' => user_profile($x, $user_id, 'district'),
            'Postal Code' => user_profile($x, $user_id, 'post_code'),
            'Address' => user_profile($x, $user_id, 'address'),
            'Residence Status' => user_profile($x, $user_id, 'residence_status'),
            'Mailing Address' => user_profile($x, $user_id, 'mailing_address'),
        ],
        'Employment Details' => [
            'Current Job' => user_profile($x, $user_id, 'current_job'),
            'Job Status' => user_profile($x, $user_id, 'job_status'),
            'Company Name' => user_profile($x, $user_id, 'company_name'),
            'Business Sector' => user_profile($x, $user_id, 'business_sector'),
            'Start Working Date' => user_profile($x, $user_id, 'start_working_date'),
            'Position' => user_profile($x, $user_id, 'position'),
        ],
        'Account Details' => [
            'Account Type' => user_profile($x, $user_id, 'account_type'),
            'Purpose' => user_profile($x, $user_id, 'purpose'),
        ],
    ];

    // Add sections to the PDF
    foreach ($details as $section => $fields) {
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, $section, 0, 1);
        $pdf->SetFont('Arial', '', 11);

        foreach ($fields as $label => $value) {
            $pdf->Cell(60, 8, $label . ':', 0, 0);
            $pdf->Cell(0, 8, $value, 0, 1);
        }
        $pdf->Ln(5); // Add some space after each section
    }

    // Output the PDF to the browser
    $pdf->Output('I', 'User_Profile.pdf'); // 'I' to display inline in browser
}
?>