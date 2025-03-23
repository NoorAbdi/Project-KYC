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

<head>
    <link href="{{ asset('../style.css') }}" rel="stylesheet" type="text/css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Main content -->
    <div class="flex flex-1 flex-col overflow-y-auto">
        <div class="flex h-16 items-center justify-between border-b border-gray-200 bg-white">
        </div>
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-2">Welcome,
                <?php echo user_profile($x,$user_id,'first_name') . ' ' . user_profile($x,$user_id,'last_name'); ?></h1>
            <div class="flex">
                <div class="container basis-1/3 flex justify-center rounded-lg bg-white mr-2">
                    <div class="flex flex-col justify-center items-center py-2">
                        <h2 class="font-bold">Registrar Profile</h2>
                        <table class="table-fixed border-collapse text-left text-sm">
                            <tr>
                                <td class="border border-gray-400 px-2 py-2" rowspan="5">
                                    <img class="mb-2 h-20 w-20"
                                        src="<?php echo pp_exist($user_id) ?>"
                                        alt="" />
                                </td>
                            </tr>
                            <tr>
                                <th class="border border-gray-400 px-2 py-2">Nomor KTP</th>
                                <td class="border border-gray-400 px-2">
                                    <?php echo !empty(user_profile($x, $user_id, 'ktp_number')) ? user_profile($x, $user_id, 'ktp_number') : '-'; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="border border-gray-400 px-2 py-2">Nama</th>
                                <td class="border border-gray-400 px-2">
                                    <?php echo (!empty(user_profile($x, $user_id, 'first_name')) ? user_profile($x, $user_id, 'first_name') : '-') . ' ' . (!empty(user_profile($x, $user_id, 'last_name')) ? user_profile($x, $user_id, 'last_name') : '-'); ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="border border-gray-400 px-2 py-2">Provinsi</th>
                                <td class="border border-gray-400 px-2">
                                    <?php echo !empty(user_profile($x, $user_id, 'province')) ? user_profile($x, $user_id, 'province') : '-'; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="border border-gray-400 px-2 py-2">Tempat, Tanggal Lahir</th>
                                <td class="border border-gray-400 px-2">
                                    <?php echo (!empty(user_profile($x, $user_id, 'place_of_birth')) ? user_profile($x, $user_id, 'place_of_birth') : '-') . ', ' . (!empty(user_profile($x, $user_id, 'date_of_birth')) ? user_profile($x, $user_id, 'date_of_birth') : '-'); ?>
                                </td>
                            </tr>
                        </table>
                        <?php
                            if (!empty(user_profile($x, $user_id, 'ktp_number'))){
                                echo '<h2 class="mx-2 py-2 font-bold text-green-500">Profile Completed</h2>';
                            }else{
                                echo '<h2 class="mx-2 py-2 font-bold text-red-500">Profile Incomplete</h2>';
                                ?>
                                <div class="flex flex-1 justify-center">
                                    <a href="detail_user.php" class="flex items-center hover:text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" class="h-6 w-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-.375 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                        </svg>
                                        <h2 class="mx-2 py-2 font-bold">Fill Profile</h2>
                                    </a>
                                </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>