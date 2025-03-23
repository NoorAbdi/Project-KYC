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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banks Data</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <style>
        /* Center-align text in the DataTable */
        #bankTable th, #bankTable td {
            text-align: center;
            vertical-align: middle; /* Ensures content is vertically aligned */
        }
    </style>
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
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4 text-center">Apply for Banks</h1>

        <div class="bg-white shadow rounded-lg p-4">
            <table id="bankTable" class="w-full table-fixed border-collapse text-left text-sm">
                <thead class="bg-gray-200 text-center uppercase">
                    <tr>
                        <th class="rounded border-b-2 border-l-2 border-b-gray-300 px-3 py-3">Bank Name</th>
                        <th class="rounded border-b-2 border-r-2 border-b-gray-300 px-3 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100 text-center">
                    <!-- Data will be populated dynamically -->
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script>
    $(document).ready(function () {
        const userId = <?php echo json_encode($user_id); ?>; // Replace with the actual logged-in user ID

        // Initialize DataTable
        const table = $('#bankTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
        });

        // Fetch all banks and user applications
        $.ajax({
            url: 'banks_api.php', // Fetch all banks
            method: 'GET',
            success: function (banks) {
                $.ajax({
                    url: 'banks_api.php', // Fetch user applications
                    method: 'GET',
                    data: { user_id: userId },
                    success: function (applications) {
                        // Extract bank IDs for all applications
                        const appliedBankIds = applications.map(app => Number(app.bank_id)); // Ensure IDs are numbers

                        // Generate rows for the DataTable
                        banks.forEach(bank => {
                            const isApplied = appliedBankIds.includes(Number(bank.id)); // Ensure comparison is consistent

                            const row = `
                                <tr class="hover:bg-gray-200">
                                    <td class="border-b-2 border-r-2 px-3 py-3 font-bold">${bank.name}</td>
                                    <td class="border-b-2 px-3 py-3 font-bold flex justify-center items-center">
                                        <button 
                                            class="apply-btn block rounded-md font-medium backdrop-blur-lg ${
                                                isApplied ? 'bg-gray-400 text-white' : 'bg-blue-400 text-black hover:bg-blue-500'
                                            } px-4 py-2" 
                                            data-bank-id="${bank.id}" 
                                            ${isApplied ? 'disabled' : ''}>
                                            ${isApplied ? 'Applied' : 'Apply'}
                                        </button>
                                    </td>
                                </tr>`;
                            table.row.add($(row)).draw(false);
                        });
                    },
                    error: function () {
                        alert('Failed to fetch user applications.');
                    }
                });
            },
            error: function () {
                alert('Failed to fetch banks.');
            }
        });

        // Handle Apply button click
        $('#bankTable').on('click', '.apply-btn:not([disabled])', function () {
            const bankId = $(this).data('bank-id');

            $.ajax({
                url: 'banks_api.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    user_id: userId,
                    bank_id: bankId,
                    status: 'To Review',
                    submitted_at: new Date().toISOString()
                }),
                success: function () {
                    alert('Application submitted successfully!');
                    $(this)
                        .text('Applied')
                        .removeClass('bg-blue-400 hover:bg-blue-500 text-black')
                        .addClass('bg-gray-400 text-white')
                        .prop('disabled', true);
                }.bind(this),
                error: function () {
                    alert('Failed to submit the application.');
                }
            });
        });
    });
</script>








</body>

</html>