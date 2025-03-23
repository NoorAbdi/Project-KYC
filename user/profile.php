<?php
session_start();
if(isset($_GET['logout'])) {
    session_unset();
    header('Location: ../login.php');
}
if(!isset($_SESSION['user_id'])){
    header('Location: ../login.php');
  }
  $user_id = $_SESSION['user_id'];

$authURL = "{$_SERVER['SERVER_NAME']}/kyc/user/u_backend.php";

$ch = curl_init($authURL);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

$x = json_decode($output,true);

function user_profile($data, $defined, $target_var){
    foreach($data["customers"] as $y){
        if($y['user_id'] == $defined){
            return $y[$target_var];
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

<!doctype html>
<html lang="en">

<head>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="flex h-screen bg-gray-100">
  <!-- sidebar -->
  <div class="hidden w-64 flex-col bg-gray-800 md:flex">
    <div class="flex h-40 flex-col items-center justify-center bg-gray-900">
      <img class="object-cover mb-2 h-20 w-20 rounded-full"
        src="<?php echo pp_exist($user_id) ?>"
        alt="" />
      <span
        class="font-bold uppercase text-white"><?php echo (!empty(user_profile($x,$user_id,'first_name')) ? user_profile($x,$user_id,'first_name') : 'Not Set') . ' ' . user_profile($x,$user_id,'last_name'); ?></span>
    </div>
    <div class="flex flex-1 flex-col overflow-y-auto">
      <nav class="flex-1 bg-gray-800 px-2 py-4">
        <a href="user_dashboard.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="mr-2 h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
          </svg>
          Dashboard
        </a>
        <a href="profile.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="mr-2 h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
          </svg>
          Profil
        </a>
        <?php
                if (!empty(user_profile($x, $user_id, 'ktp_number'))){ ?>
        <a href="register_bank.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
          <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M6 14h2m3 0h4m2 2h2m0 0h2m-2 0v2m0-2v-2m-5 4H4c-.55228 0-1-.4477-1-1V7c0-.55228.44772-1 1-1h16c.5523 0 1 .44772 1 1v4M3 10h18" />
          </svg>
          Daftar Bank
        </a>
        <a href="check_bank.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
          <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
          </svg>
          Cek Status
        </a>
        <?php } ?>
        <a href="print_daftar.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="mr-2 h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
          </svg>
          Cetak Bukti Daftar
        </a>
        <a href="?logout" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="mr-2 h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
          </svg>
          Logout
        </a>
      </nav>
    </div>
  </div>
  <!-- Personal Details -->
  <div class="flex flex-col flex-1 overflow-y-auto ml-10 mt-6">
    <h1 class="mb-6 text-2xl font-bold text-gray-800 text-center">User Profile</h1>
    <form x-data="{photoName: null, photoPreview: null, error: null}" action="upload.php" method="POST"
          enctype="multipart/form-data" class="col-span-6 ml-2 sm:col-span-4 md:mr-3">
          <!-- Hidden File Input -->
          <input type="file" name="photo" class="hidden" x-ref="photo" x-on:change="
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
        ">

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
              <img src="<?php echo pp_exist($user_id) ?>" class="object-cover w-40 h-40 m-auto rounded-full shadow">
            </div>

            <!-- New Profile Photo Preview -->
            <div class="mt-2" x-show="photoPreview" style="display: none;">
              <span class="block w-40 h-40 rounded-full m-auto shadow"
                x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'"></span>
            </div>
            <input type="hidden" value="<?php echo $user_id ?>" name="user_id">
            <button type="button"
              class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-400 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150 mt-2 ml-3"
              x-on:click.prevent="$refs.photo.click()">
              Select New Photo
            </button>
            <!-- Submit Button -->
            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
              :disabled="error">
              Upload Photo
            </button>
          </div>
        </form>
    <section class="mb-6">
      <h2 class="mb-3 text-xl font-semibold text-gray-700">Personal Details</h2>
      <div class="grid grid-cols-2 gap-4">
        <div><strong>KTP Number:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'ktp_number')) ? user_profile($x,$user_id,'ktp_number') : '-') ?></span>
        </div>
        <div><strong>First Name:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'first_name')) ? user_profile($x,$user_id,'first_name') : '-') ?></span>
        </div>
        <div><strong>Last Name:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'last_name')) ? user_profile($x,$user_id,'last_name') : '-') ?></span>
        </div>
        <div><strong>Gender:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'gender')) ? user_profile($x,$user_id,'gender') : '-') ?></span>
        </div>
        <div><strong>Religion:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'religion')) ? user_profile($x,$user_id,'religion') : '-') ?></span>
        </div>
        <div><strong>Education:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'education')) ? user_profile($x,$user_id,'education') : '-') ?></span>
        </div>
        <div><strong>Date of Birth:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'date_of_birth')) ? user_profile($x,$user_id,'date_of_birth') : '-') ?></span>
        </div>
        <div><strong>Place of Birth:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'place_of_birth')) ? user_profile($x,$user_id,'place_of_birth') : '-') ?></span>
        </div>
        <div><strong>Phone Number:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'phone_number')) ? user_profile($x,$user_id,'phone_number') : '-') ?></span>
        </div>
        <div><strong>Marital Status:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'marital_status')) ? user_profile($x,$user_id,'marital_status') : '-') ?></span>
        </div>
        <div><strong>Province:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'province')) ? user_profile($x,$user_id,'province') : '-') ?></span>
        </div>
        <div><strong>Regency/City:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'regency_city')) ? user_profile($x,$user_id,'regency_city') : '-') ?></span>
        </div>
        <div><strong>District:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'district')) ? user_profile($x,$user_id,'district') : '-') ?></span>
        </div>
        <div><strong>Postal Code:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'post_code')) ? user_profile($x,$user_id,'post_code') : '-') ?></span>
        </div>
        <div><strong>Address:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'last_name')) ? user_profile($x,$user_id,'last_name') : '-') ?></span>
        </div>
        <div><strong>Residence Status:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'address')) ? user_profile($x,$user_id,'address') : '-') ?></span>
        </div>
        <div><strong>Mailing Address:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'mailing_address')) ? user_profile($x,$user_id,'mailing_address') : '-') ?></span>
        </div>
      </div>
    </section>

    <!-- Employment Details -->
    <section class="mb-6">
      <h2 class="mb-3 text-xl font-semibold text-gray-700">Employment Details</h2>
      <div class="grid grid-cols-2 gap-4">
        <div><strong>Current Job:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'current_job')) ? user_profile($x,$user_id,'current_job') : '-') ?></span>
        </div>
        <div><strong>Job Status:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'job_status')) ? user_profile($x,$user_id,'job_status') : '-') ?></span>
        </div>
        <div><strong>Company Name:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'company_name')) ? user_profile($x,$user_id,'company_name') : '-') ?></span>
        </div>
        <div><strong>Business Sector:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'business_sector')) ? user_profile($x,$user_id,'business_sector') : '-') ?></span>
        </div>
        <div><strong>Start Working Date:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'start_working_date')) ? user_profile($x,$user_id,'start_working_date') : '-') ?></span>
        </div>
        <div><strong>Position:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'position')) ? user_profile($x,$user_id,'position') : '-') ?></span>
        </div>
      </div>
    </section>

    <!-- Account Details -->
    <section>
      <h2 class="mb-3 text-xl font-semibold text-gray-700">Account Details</h2>
      <div class="grid grid-cols-2 gap-4">
        <div><strong>Account Type:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'account_type')) ? user_profile($x,$user_id,'account_type') : '-') ?></span>
        </div>
        <div><strong>Purpose:</strong> <span
            class="text-gray-600"><?php echo (!empty(user_profile($x,$user_id,'purpose')) ? user_profile($x,$user_id,'purpose') : '-') ?></span>
        </div>
      </div>
    </section>
  </div>
</div>
</div>

</html>