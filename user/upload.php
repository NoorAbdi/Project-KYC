<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_POST["user_id"];
    $upload_dir = "user_file/" . $user_id . "/";

    // Ensure the upload directory exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Validate the uploaded file
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["photo"]["tmp_name"];
        $file_name = $_FILES["photo"]["name"];

        // Check if the uploaded file is an image
        $image_type = exif_imagetype($tmp_name);
        if (!$image_type) {
            die("Uploaded file is not a valid image.");
        }

        // Get the file extension
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // Define the new file name
        $new_file_name = $user_id . "_pp." . $file_extension;
        $upload_path = $upload_dir . $new_file_name;

        // Delete any existing file with the same pattern (e.g., 1_pp.*)
        $existing_files = glob($upload_dir . $user_id . "_pp.*");
        foreach ($existing_files as $existing_file) {
            if (is_file($existing_file)) {
                unlink($existing_file);
            }
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($tmp_name, $upload_path)) {
            header('Location: ./profile.php');
        } else {
            die("Failed to move uploaded file.");
        }
    } else {
        die("File upload error or no file uploaded.");
    }
} else {
    die("Invalid request.");
}
?>
