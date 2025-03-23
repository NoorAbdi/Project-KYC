<?php
session_start();
if(isset($_GET['logout'])) {
    session_unset();
    header('Location: ../login.php');
}

if(!isset($_SESSION['placement'])){
    header('Location: ../login.php');
  }
$placement = $_SESSION['placement'];
$t_v = $_SESSION["email"];
$user_id = $_SESSION["user_id"];

$authURL = "{$_SERVER['SERVER_NAME']}/kyc/compliance/c_backend.php?level=compliance&placement=$placement";

$ch = curl_init($authURL);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

$x = json_decode($output,true);

function compliance_profile($data, $defined, $target_var){
    foreach($data["compliance"] as $y){
        foreach($y as $a){
            if($a["Email"] === $defined){
                return $a[$target_var];
            }
        }
    }
}
function pp_exist($uid) {
    // Base directory and file name
    $baseDir = './user_file/' . $uid . '/';
    $baseFile = $baseDir . $uid . '_pp';

    // Possible file extensions
    $extensions = ['.png', '.jpg', '.jpeg', '.gif'];

    // Default file
    $defaultFile = '../asset/default_pp.png';

    // Check each extension
    foreach ($extensions as $ext) {
        $file = $baseFile . $ext;
        if (file_exists($file)) {
            return $file; // Return the file if it exists
        }
    }

    // Return the default file if none found
    return $defaultFile;
}

?>

<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KYSys - Your best bank account manager!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../tailwind.js"></script>
    <link rel="stylesheet" href="../style.css" />
</head>

<div class="flex h-screen bg-gray-100">
    <!-- sidebar -->
    <div class="hidden w-64 flex-col bg-gray-800 md:flex">
        <div class="flex h-40 flex-col items-center justify-center bg-gray-900">
            <img class="object-cover mb-2 h-20 w-20 rounded-full"
                src="<?php echo pp_exist($user_id) ?>"
                alt="" />
            <span
                class="font-bold uppercase text-white"><?php echo compliance_profile($x, $t_v,'FirstName') . ' ' . compliance_profile($x, $t_v,'LastName'); ?></span>
            <span class="uppercase text-white text-xs">Compliance Officer</span>
        </div>
        <div class="flex flex-1 flex-col overflow-y-auto">
            <nav class="flex-1 bg-gray-800 px-2 py-4">
                <a href="user_rev_dashboard.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                    Profil
                </a>
                <a href="print_user.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                    Cetak Bukti Pendaftar
                </a>
                <a href="?logout" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                    Logout
                </a>
            </nav>
        </div>
    </div>
    <div class="flex flex-1 flex-col overflow-y-auto">
    <form 
    x-data="{photoName: null, photoPreview: null, error: null}" 
    action="upload.php" 
    method="POST" 
    enctype="multipart/form-data"
    class="col-span-6 ml-2 sm:col-span-4 md:mr-3"
>
    <!-- Hidden File Input -->
    <input 
        type="file" 
        name="photo" 
        class="hidden" 
        x-ref="photo" 
        x-on:change="
            error = null; // Clear any previous errors
            const file = $refs.photo.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) { // 2 MB limit
                    error = 'File size exceeds 2 MB.';
                    photoName = null;
                    photoPreview = null;
                    $refs.photo.value = ''; // Reset file input
                } else {
                    photoName = file.name;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        photoPreview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        "
    >

    <label class="block text-gray-700 text-sm font-bold mb-2 text-center" for="photo">
        Profile Photo <span class="text-red-600"> </span>
    </label>
    
    <div class="text-center">
        <!-- Error Message -->
        <div x-show="error" class="text-red-600 mb-2">
            <span x-text="error"></span>
        </div>

        <!-- Current Profile Photo -->
        <div class="mt-2" x-show="!photoPreview && !error">
            <img src="<?php echo pp_exist($user_id) ?>" 
                class="object-cover w-40 h-40 m-auto rounded-full shadow">
        </div>
        
        <!-- New Profile Photo Preview -->
        <div class="mt-2" x-show="photoPreview" style="display: none;">
            <span 
                class="block w-40 h-40 rounded-full m-auto shadow" 
                x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"
            ></span>
        </div>
        <input type="hidden" value="<?php echo $user_id ?>" name="user_id">
        <button 
            type="button" 
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3" 
            x-on:click.prevent="$refs.photo.click()"
        >
            Select New Photo
        </button>
        <!-- Submit Button -->
    <button 
        type="submit" 
        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
        :disabled="error"
    >
        Upload Photo
    </button>
    </div>
</form>

        <div class="mb-6 mt-6 gap-6 flex flex-wrap items-center justify-center">
            <div>
                <h2 class="text-lg font-medium ml-4">Name:</h2>
                <h2 class="text-lg font-medium ml-4">
                    <?php echo compliance_profile($x, $t_v,'FirstName') . ' ' . compliance_profile($x, $t_v,'LastName'); ?>
                </h2>
            </div>
            <div>
                <h2 class="text-lg font-medium ml-4">Occupation:</h2>
                <h2 class="text-lg font-medium ml-4"><?php echo compliance_profile($x, $t_v,'bank_name'); ?></h2>
            </div>
        </div>
        <div class="mb-6 mt-6 gap-6 flex flex-wrap items-center justify-center">
            <div>
                <h2 class="text-lg font-medium ml-4">Email:</h2>
                <h2 class="text-lg font-medium ml-4">
                    <?php echo compliance_profile($x, $t_v,'Email') . ' ' . compliance_profile($x, $t_v,'LastName'); ?>
                </h2>
            </div>
            <div>
                <h2 class="text-lg font-medium ml-4">Role:</h2>
                <h2 class="text-lg font-medium ml-4">Compliance Officer</h2>
            </div>
            <div>
                <h2 class="text-lg font-medium ml-4">Phone Number:</h2>
                <h2 class="text-lg font-medium ml-4">+62155267323635</h2>
            </div>
        </div>
    </div>
</div>