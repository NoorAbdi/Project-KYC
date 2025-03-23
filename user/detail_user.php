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
      if($y[$target_var] == $defined){
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

<head>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>KYSys - Your best bank account manager!</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="../tailwind.js"></script>
  <link rel="st ylesheet" href="../style.css" />
</head>

<div class="flex h-fit bg-gray-100">
    <!-- sidebar -->
    <div class="hidden w-64 flex-col bg-gray-800 md:flex">
        <div class="flex h-40 flex-col items-center justify-center bg-gray-900">
            <img class="mb-2 h-20 w-20 rounded-full"
                src="<?php echo pp_exist($user_id) ?>"
                alt="" />
            <span
                class="font-bold uppercase text-white"><?php echo (!empty(user_profile($x,$user_id,'first_name')) ? user_profile($x,$user_id,'first_name') : 'Not Set') . ' ' . user_profile($x,$user_id,'last_name'); ?></span>
        </div>
        <div class="flex flex-1 flex-col overflow-y-auto">
            <nav class="flex-1 bg-gray-800 px-2 py-4">
                <a href="user_dashboard.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Dashboard
                </a>
                <a href="profile.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
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
                        <svg class="mr-2 h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                            height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M6 14h2m3 0h5M3 7v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1Z" />
                        </svg>
                        Cek Status
                    </a>
                <?php } ?>
                <a href="print_daftar.php" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="mr-2 h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                    Cetak Bukti Daftar
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

  <div class="ml-5 mt-5 flex flex-col">
    <form action="submit_identity.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
      <div id="step-1" class="step">
        <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-black">Personal details</h3>
        <div class="mb-6">
          <label for="ktpnum" class="mb-2 block text-sm font-medium text-gray-900">KTP Number*</label>
          <input name="ktpnum" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==16) return false;" id="ktpnum" placeholder="Enter your KTP code numbers .."
            class="mb-5 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
            required />
        </div>
        <div class="mb-6">
          <label for="fname" class="mb-2 block text-sm font-medium text-gray-900">Name based on KTP*</label>
          <div class="grid grid-cols-2 gap-3">
            <input type="text" id="fname" name="fname" placeholder="First name on KTP .."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
            <input type="text" id="lname" name="lname" placeholder="Last name on KTP .."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
          </div>
        </div>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="maiden_name" class="mb-2 block text-sm font-medium text-gray-900">Mother's Maiden Name*</label>
            <input type="text" placeholder="Your mother's name .." name="maiden_name" id="maiden_name"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="gender_male" class="mb-2 block text-sm font-medium text-gray-900">Gender*</label>
            <div class="flex items-center">
              <input type="radio" id="gender_male" value="Male" name="gender" />
              <label for="gender_male" class="mr-4 pl-1">Male</label>
              <input type="radio" id="gender_fmale" value="Female" name="gender" />
              <label for="gender_fmale" class="pl-1">Female</label>
            </div>
          </div>
        </div>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="religion" class="mb-2 block text-sm font-medium text-gray-900">Religion*</label>
            <select name="religion" id="religion" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your religion ..</option>
              <option  value="Islam">Islam</option>
              <option  value="Buddha">Buddha</option>
              <option  value="Protestan">Protestan</option>
              <option  value="Katolik">Katolik</option>
              <option  value="Hindu">Hindu</option>
              <option  value="Khong Hu Cu">Khong Hu Cu</option>
            </select>
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="education" class="mb-2 block text-sm font-medium text-gray-900">Education*</label>
            <select name="education" id="education" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your education ..</option>
              <option  value="SD">SD</option>
              <option  value="SMA">SMA</option>
              <option  value="Diploma">Diploma</option>
              <option  value="S1">S1</option>
              <option  value="S2">S2</option>
              <option  value="S3">S3</option>
            </select>
          </div>
        </div>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="bod" class="mb-2 block text-sm font-medium text-gray-900">Date of Birth*</label>
            <input type="date" name="dob" id="bod"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="place_dob" class="mb-2 block text-sm font-medium text-gray-900">Place of Birth*</label>
            <input type="text" name="place_dob" id="place_dob" placeholder="Place of birth .."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
          </div>
        </div>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="phone_num" class="mb-2 block text-sm font-medium text-gray-900">Phone Number*</label>
            <input type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==15) return false;" name="phone_num" id="phone_num" placeholder="0847124XX.."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="marital_status" class="mb-2 block text-sm font-medium text-gray-900">Marital Status*</label>
            <select name="marital_status" id="marital_status" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your status ..</option>
              <option value="Lajang">Lajang</option>
              <option value="Menikah">Menikah</option>
              <option value="Duda/Janda">Duda/Janda</option>
            </select>
          </div>
        </div>
        <div class="mb-8 flex flex-wrap">
          <div class="mr-4">
            <label for="province" class="mb-2 block columns-1 text-sm font-medium text-gray-900">Province*</label>
            <select name="province" id="province" class="columns-1 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your province</option>
            </select>
          </div>
          <div class="mb-2 mr-4">
            <label for="regency" class="mb-2 block columns-1 text-sm font-medium text-gray-900">Regency/City*</label>
            <select name="regency" id="regency" class="columns-1 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your Regency/City</option>
            </select>
          </div>
          <div class="mr-4">
            <label for="district" class="mb-2 block columns-1 text-sm font-medium text-gray-900">District*</label>
            <select name="district" id="district" class="columns-1 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your District</option>
            </select>
          </div>
          <div class="mr-7">
            <label for="post_code" class="mb-2 block columns-1 text-sm font-medium text-gray-900">Post Code*</label>
            <input name="post_code" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==5) return false;" placeholder="12345"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
              required />
          </div>
          <div class="flex flex-wrap">
            <div class="mr-4">
              <label for="address" class="mb-2 block columns-1 text-sm font-medium text-gray-900">Address*</label>
              <textarea rows="2" name="address"
                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 pr-20 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                placeholder="Write your house address here .."></textarea>
            </div>
            <div class="flex flex-col">
              <label class="mb-2 block columns-1 text-sm font-medium text-gray-900">Residence Status*</label>
              <select name="residence" id="residence" class="columns-1 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
                required>
                <option selected>Choose your Residence status</option>
                <option value="Milik Sendiri">Milik Sendiri</option>
                <option value="Milik Keluarga">Milik Keluarga</option>
                <option value="Sewa/Kontrakan">Sewa/Kontrakan</option>
                <option value="Dinas/Instansi">Dinas/Instansi</option>
              </select>
              <label class="mb-2 mt-2 block columns-1 text-sm font-medium text-gray-900">Mailing Address*</label>
              <select name="mailing" id="mailing" class="columns-1 rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
                required>
                <option selected>Choose your Mailing address</option>
                <option value="Alamat Sesuai ID">Alamat Sesuai ID</option>
                <option value="Alamat Tinggal">Alamat Tinggal</option>
                <option value="Alamat Kantor">Alamat Kantor</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div id="step-2" class="step">
        <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-black">Employment details</h3>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="current_job" class="mb-2 block text-sm font-medium text-gray-900">Current job*</label>
            <select name="current_job" id="current_job" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900"
              required>
              <option selected>Choose your current job ..</option>
              <option value="Wiraswasta">Wiraswasta</option>
              <option value="Swasta">Swasta</option>
              <option value="PNS/TNI/POLRI">PNS/TNI/POLRI</option>
              <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
              <option value="Penyelenggaran Negara">Penyelenggaran Negara</option>
              <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
            </select>
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="job_status" class="mb-2 block text-sm font-medium text-gray-900">Job status</label>
            <select name="job_status" id="job_status" class="w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900" required>
              <option selected>Choose your job status ..</option>
              <option value="Tetap">Tetap</option>
              <option value="Paruh Waktu">Paruh Waktu</option>
              <option value="Kontrak">Kontrak</option>
              <option value="Honorer">Honorer</option>
              <option value="Honorer">Pelajar/Mahasiswa</option>
            </select>
          </div>
        </div>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="company" class="mb-2 block text-sm font-medium text-gray-900">Company Name</label>
            <input name="company" type="number" placeholder="Your company's name .."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500" />
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="business_sector" class="mb-2 block text-sm font-medium text-gray-900">Business Sector</label>
            <input name="business_sector" type="number" placeholder="Your Business Sector .."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500" />
          </div>
        </div>
        <div class="mb-6 flex flex-wrap items-center justify-between">
          <div class="w-full sm:w-1/2">
            <label for="date_start_work" class="mb-2 block text-sm font-medium text-gray-900">Date Start Working</label>
            <input type="date" name="date_start_work" id="date_start_work"
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500" />
          </div>
          <div class="w-full px-3 sm:w-1/2">
            <label for="job_position" class="mb-2 block text-sm font-medium text-gray-900">Position</label>
            <input type="text" id="job_position" placeholder="Your Current Job Position .."
              class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"/>
          </div>
        </div>
      </div>
      <div id="step-3" class="step">
        <h3 class="mb-4 text-lg font-medium leading-none text-gray-900 dark:text-black">New account opening</h3>
        <div class="mb-6 flex flex-col">
          <label for="acc_type" class="mb-2 block text-sm font-medium text-gray-900">Account Type*</label>
          <div class="grid grid-cols-2 grid-rows-3">
            <div>
              <input type="radio" value="Tabungan" id="acc_type" name="acc_type" required />
              <label for="mandiri_tabungan" class="pl-1">Tabungan</label>
            </div>

            <div>
              <input type="radio" value="Tabungan Bisnis" id="acc_type" name="acc_type" />
              <label for="mandiri_tabungan_bisnis" class="pl-1">Tabungan Bisnis</label>
            </div>

            <div>
              <input type="radio" value="Bisnis" id="acc_type" name="acc_type" />
              <label for="mandiri_bisnis" class="pl-1">Bisnis</label>
            </div>

            <div>
              <input type="radio" value="Tabungan Valas" id="acc_type" name="acc_type" />
              <label for="mandiri_tabungan_valas" class="pl-1">Tabungan Valas</label>
            </div>

            <div>
              <input type="radio" value="Tabungan Mitra Usaha" id="acc_type" name="acc_type" />
              <label for="mandiri_tabungan_mitra" class="pl-1">Tabungan Mitra Usaha</label>
            </div>

            <div>
              <input type="radio" value="Tabungan Karyawan/Pelajar" id="acc_type" name="acc_type" />
              <label for="mandiri_tabungan_karyawan" class="pl-1">Tabungan Karyawan/Pelajar</label>
            </div>
          </div>
          <label for="purpose" class="mb-2 mt-2 block text-sm font-medium text-gray-900">Purpose of Relationship with Bank*</label>
          <div class="flex">
            <div class="mr-4">
              <input type="radio" value="Saving" id="purpose" name="purpose" required />
              <label for="Saving" class="pl-1">Saving</label>
            </div>
            <div class="mr-4">
              <input type="radio" value="Investment" id="purpose" name="purpose" />
              <label for="Investment" class="pl-1">Investment</label>
            </div>
            <div class="mr-4">
              <input type="radio" value="Loan/Credit" id="purpose" name="purpose" />
              <label for="Loan/Credit" class="pl-1">Loan/Credit</label>
            </div>
            <div class="mr-4">
              <input type="radio" value="Business Transaction" id="purpose" name="purpose" />
              <label for="Business_Transaction" class="pl-1">Business Transaction</label>
            </div>
          </div>
          <label class="mt-3 block font-medium" for="img_upload1">Upload KTP Image:</label>
        <input type="file" accept="image/*" name="img_upload1" id="img_upload1" class="mt-2 cursor-pointer rounded bg-gray-100 text-sm font-medium text-gray-500 file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-800 file:px-4 file:py-2 file:text-white file:hover:bg-gray-700" required/>
      <label class="mt-3 block font-medium" for="img_upload2">Upload KK Image:</label>
        <input type="file" accept="image/*" name="img_upload2" id="img_upload2" class="mt-2 cursor-pointer rounded bg-gray-100 text-sm font-medium text-gray-500 file:mr-4 file:cursor-pointer file:border-0 file:bg-gray-800 file:px-4 file:py-2 file:text-white file:hover:bg-gray-700" required/>
        </div>
      </div>
      <div class="mt-5 mb-5 flex justify-center">
        <button type="submit"
          class="rounded bg-green-600 px-6 py-2 text-white font-medium hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-300">
          Save Information
        </button>
      </div>
    </form>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function () {
  const provinceSelect = document.getElementById("province");
  const regencySelect = document.getElementById("regency");
  const districtSelect = document.getElementById("district");

  // Fetch Provinces
  fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json")
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then(data => {
      if (!Array.isArray(data)) {
        console.error("Invalid provinces data format:", data);
        return;
      }

      // Populate provinces
      data.forEach(province => {
        const option = document.createElement("option");
        option.value = province.id;
        option.textContent = province.name;
        provinceSelect.appendChild(option);
      });
    })
    .catch(error => console.error("Error fetching provinces:", error));

  // On Province Change
  provinceSelect.addEventListener("change", function () {
    const provinceId = provinceSelect.value;

    // Clear previous regency and district options
    regencySelect.innerHTML = '<option selected>Choose your Regency/City</option>';
    districtSelect.innerHTML = '<option selected>Choose your District</option>';

    if (provinceId) {
      // Fetch Regencies
      fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          if (!Array.isArray(data)) {
            console.error("Invalid regencies data format:", data);
            return;
          }

          // Populate regencies
          data.forEach(regency => {
            const option = document.createElement("option");
            option.value = regency.id;
            option.textContent = regency.name;
            regencySelect.appendChild(option);
          });
        })
        .catch(error => console.error("Error fetching regencies:", error));
    }
  });

  // On Regency Change
  regencySelect.addEventListener("change", function () {
    const regencyId = regencySelect.value;

    // Clear previous district options
    districtSelect.innerHTML = '<option selected>Choose your District</option>';

    if (regencyId) {
      // Fetch Districts
      fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${regencyId}.json`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          if (!Array.isArray(data)) {
            console.error("Invalid districts data format:", data);
            return;
          }

          // Populate districts
          data.forEach(district => {
            const option = document.createElement("option");
            option.value = district.id;
            option.textContent = district.name;
            districtSelect.appendChild(option);
          });
        })
        .catch(error => console.error("Error fetching districts:", error));
    }
  });
});

</script>