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
$user_id = $_SESSION['user_id'];

$authURL = "{$_SERVER['SERVER_NAME']}/kyc/compliance/c_backend.php?level=compliance&placement=$placement";

$ch = curl_init($authURL);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

$x = json_decode($output,true);

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


function compliance_profile($data, $defined, $target_var){
    foreach($data["compliance"] as $y){
        foreach($y as $a){
            if($a["Email"] === $defined){
                return $a[$target_var];
            }
        }
    }
}

function data_counter($option,$data){
    $count = 0;
    if($option === 1){
        foreach($data["customers"] as $y){
                if($y["status"] === 'Approved'){
                    $count += 1;
            }
        }
    }elseif($option === 0){
        foreach($data["customers"] as $y){
            if($y["status"] === 'To Review'){
                $count += 1;
            }
        }
    }elseif($option === 'c'){
        foreach($data["customers"] as $y){
            $count += 1;
        }
    }
    return $count;
}
function unique($data, $target) {
    $seen = []; // Array to track unique values of the target field

    foreach ($data["customers"] as $arr) {
        // Ensure the target key exists in the array
        if (isset($arr[$target])) {
            // Add the value to the seen array if not already present
            if (!in_array($arr[$target], $seen)) {
                $seen[] = $arr[$target];
            }
        }
    }
    
    return count($seen);
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

    <style>
        /* Center-align text in the DataTable */
        #customerTable th, #customerTable td {
            text-align: center;
            vertical-align: middle; /* Ensures content is vertically aligned */
        }
        #userModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    #modalContent {
        background: white;
        padding: 20px;
        border-radius: 8px;
        max-width: 90%;
        max-height: 90%;
        overflow-y: auto; /* Enable vertical scrolling */
    }

    #userDetails img {
        max-width: 100%; /* Fit within the container width */
        max-height: 300px; /* Limit height */
        display: block;
        margin: 10px auto;
    }

    #closeModal {
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 18px;
        background: #ff6666;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 5px;
    }
    #userModal img {
        max-width: 100%; /* Ensure images fit within the container */
        max-height: 300px; /* Limit the height of images */
        display: block;
        margin: 10px auto; /* Center images within the container */
    }

    .max-h-screen {
        max-height: calc(100vh - 40px); /* Limit the modal height to the viewport, with padding */
        overflow-y: auto; /* Enable vertical scrolling for overflowing content */
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
            <span class="font-bold uppercase text-white"><?php echo compliance_profile($x, $_SESSION['email'],'FirstName') . ' ' . compliance_profile($x, $_SESSION['email'],'LastName'); ?></span>
            <span class="uppercase text-white text-xs">Compliance Officer</span>
        </div>
        <div class="flex flex-1 flex-col overflow-y-auto">
            <nav class="flex-1 bg-gray-800 px-2 py-4">
                <a href="#" class="flex items-center px-4 py-3 text-gray-100 hover:bg-gray-700">
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

    <!-- Main content -->
    <div class="flex flex-1 flex-col overflow-y-auto">
        <div class="flex h-16 items-center justify-between border-b border-gray-200 bg-white ">
            <h1 class="mb-2 ml-2 text-2xl font-bold">Customer Reviewing Dashboard</h1>
        </div>
        <div class="p-4">
            <div class="flex justify-evenly">
                <div
                    class="container mr-2 h-24 flex basis-1/6 justify-center rounded-lg bg-kyc-third text-white text-center">
                    <div class="items-center justify-center py-2">
                        <h2 class="text-1xl align-top font-bold">Customers</h2>
                        <span class="text-5xl inline-block align-middle font-bold"><?php echo data_counter('c',$x); ?></span>
                    </div>
                </div>
                <div
                    class="container mr-2 h-24 flex basis-1/6 justify-center rounded-lg bg-kyc-third text-white text-center">
                    <div class="items-center justify-center py-2">
                        <h2 class="text-1xl align-top font-bold">Approved</h2>
                        <span class="text-5xl inline-block align-middle font-bold"><?php echo data_counter(1,$x); ?></span>
                    </div>
                </div>
                <div
                    class="container mr-2 h-24 flex basis-1/6 justify-center rounded-lg bg-kyc-third text-white text-center">
                    <div class="items-center justify-center py-2">
                        <h2 class="text-1xl align-top font-bold">To Review</h2>
                        <span class="text-5xl inline-block align-middle font-bold"><?php echo data_counter(0,$x); ?></span>
                    </div>
                </div>
                <div
                    class="container mr-2 h-24 flex basis-1/6 justify-center rounded-lg bg-kyc-third text-white text-center">
                    <div class="items-center justify-center py-2">
                        <h2 class="text-1xl align-top font-bold">Province</h2>
                        <span class="text-5xl inline-block align-middle font-bold"><?php echo unique($x, 'province'); ?></span>
                    </div>
                </div>
            </div>
            <div class="w-full mt-10 flex items-center justify-center">
                <table id="customerTable" class="w-full table-fixed border-collapse text-left text-sm">
                    <thead class="bg-gray-200 text-center uppercase">
                        <tr>
                            <th class="rounded border-b-2 border-l-2 border-b-gray-300 px-3 py-3">Surname</th>
                            <th class="border-b-2 border-b-gray-300 px-3 py-3">Last Name</th>
                            <th class="border-b-2 border-b-gray-300 px-3 py-3">Email</th>
                            <th class="border-b-2 border-b-gray-300 px-3 py-3">Phone Number</th>
                            <th class="border-b-2 border-b-gray-300 px-3 py-3">Birth Date</th>
                            <th class="border-b-2 border-b-gray-300 px-3 py-3">KTP Number</th>
                            <th class="border-b-2 border-b-gray-300 px-3 py-3">Province</th>
                            <th class="rounded border-b-2 border-r-2 border-b-gray-300 px-3 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-100 text-center">
                        <?php
                        foreach($x["customers"] as $y){
                                echo '<tr class="hover:bg-gray-200">';
                                echo '<td class="border-b-2 border-l-2 px-3 py-3 font-bold">'. $y["first_name"] .'</td>';
                                echo '<td class="border-b-2 px-3 py-3 font-bold">'. $y["last_name"] .'</td>';
                                echo '<td class="border-b-2 px-3 py-3 font-bold">'. $y["customer_email"] .'</td>';
                                echo ' <td class="border-b-2 px-3 py-3 font-bold">'. $y["phone_number"] .'</td>';
                                echo '<td class="border-b-2 px-3 py-3 font-bold">'. $y["date_of_birth"] .'</td>';
                                echo '<td class="border-b-2 px-3 py-3 font-bold">'. $y["ktp_number"] .'</td>';
                                echo '<td class="border-b-2 px-3 py-3 font-bold">'. $y["province"] .'</td>';
                                echo '<td class="border-b-2 border-r-2 px-3 py-3 font-bold flex justify-center items-center">';
                                if($y["status"] === 'Approved'){
                                    echo '<button class="block rounded-md bg-green-400 hover:bg-green-500 px-4 py-2 font-medium backdrop-blur-lg text-center">'. $y["status"] .'</button></td></tr>';
                                }else if($y["status"] === 'To Review'){
                                    echo '<button class="to-review-btn block rounded-md bg-orange-400 hover:bg-orange-500 px-4 py-2 font-medium backdrop-blur-lg text-center" data-id="' . $y["customer_id"] . '">'. $y["status"] .'</button></td></tr>';
                                }else if($y["status"] === 'Rejected'){
                                    echo '<button class="block rounded-md bg-red-400 hover:bg-red-500 px-4 py-2 font-medium backdrop-blur-lg text-center">'. $y["status"] .'</button></td></tr>';
                                }
                        }                        
                        ?>
                    </tbody>
                </table>
            </div>
             <!-- Modal -->
        </div>
    </div>
</div>
<div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-3xl max-h-screen overflow-y-auto relative">
        <h2 class="text-xl font-bold mb-4">User Details</h2>
        <div id="userDetails" class="mb-4">
            <!-- User details will be loaded dynamically -->
        </div>
        <div class="flex justify-between mt-4">
            <button id="approveBtn" class="bg-green-500 text-white px-4 py-2 rounded">Approve</button>
            <button id="disapproveBtn" class="bg-red-500 text-white px-4 py-2 rounded">Reject</button>
        </div>
        <button id="closeModal" class="bg-slate-500 text-white px-4 py-2 rounded">Close</button>
    </div>
</div>


<script>
    $(document).ready(function () {
        $('#customerTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: false,
        });

        // Show modal with user details
        $('.to-review-btn').on('click', function () {
            const userId = $(this).data('id');
            console.log(`Fetching details for User ID: ${userId}`);

            // Fetch user details
            $.ajax({
                url: 'c_backend.php?level=user&id=' + userId,
                type: 'GET',
                success: function (response) {
                    console.log('Response received:', response);
                    if (response.status === "success") {
                        const user = response.user;
                        console.log(user);

                        // Search for image files with different extensions
                        const imageExtensions = ['jpg', 'jpeg', 'png'];

                        let kkImage = '';
                        let ktpImage = '';

                        for (const ext of imageExtensions) {
                            const kkPath = `../user/user_file/${user.user_id}/${user.user_id}_kk.${ext}`;
                            const ktpPath = `../user/user_file/${user.user_id}/${user.user_id}_ktp.${ext}`;

                            // Check if image exists (async check skipped here for simplicity)
                            kkImage += `<img src="${kkPath}" onerror="this.style.display='none';" alt="KK Image" />`;
                            ktpImage += `<img src="${ktpPath}" onerror="this.style.display='none';" alt="KTP Image" />`;
                        }

                        $('#userDetails').html(`
                            <p><strong>KTP Number:</strong> ${user.ktp_number}</p>
                            <p><strong>Name:</strong> ${user.first_name} ${user.last_name}</p>
                            <p><strong>Email:</strong> ${user.customer_email}</p>
                            <p><strong>Mother's Maiden Name:</strong> ${user.mother_maiden_name}</p>
                            <p><strong>Education:</strong> ${user.education}</p>
                            <p><strong>Phone Number:</strong> ${user.phone_number}</p>
                            <p><strong>Religion:</strong> ${user.religion}</p>
                            <p><strong>Gender:</strong> ${user.gender}</p>
                            <p><strong>Birth Place/Date:</strong> ${user.place_of_birth}, ${user.date_of_birth}</p>
                            <p><strong>Province:</strong> ${user.province}</p>
                            <p><strong>Regency/City:</strong> ${user.regency_city}</p>
                            <p><strong>District:</strong> ${user.district}</p>
                            <p><strong>Post Code:</strong> ${user.post_code}</p>
                            <p><strong>Address:</strong> ${user.address}</p>
                            <p><strong>Residence Status:</strong> ${user.residence_status}</p>
                            <p><strong>Mailing Address:</strong> ${user.mailing_address}</p>
                            <p><strong>Marital Status:</strong> ${user.marital_status}</p>
                            <p><strong>Current Job:</strong> ${user.current_job}</p>
                            <p><strong>Job Status:</strong> ${user.job_status}</p>
                            <p><strong>Company Name:</strong> ${user.company_name}</p>
                            <p><strong>Business Sector:</strong> ${user.business_sector}</p>
                            <p><strong>Start Working Date:</strong> ${user.start_working_date}</p>
                            <p><strong>Position:</strong> ${user.position}</p>
                            <p><strong>Account Type:</strong> ${user.account_type}</p>
                            <p><strong>Purpose:</strong> ${user.purpose}</p>
                            <p><strong>Status:</strong> ${user.status}</p>
                            <p><strong>Submitted At:</strong> ${user.submitted_at}</p>
                            ${kkImage}
                            ${ktpImage}
                        `);
                        $('#userModal').css('display', 'flex');
                    } else {
                        alert(response.message || 'Failed to fetch user details.');
                    }
                },
                error: function () {
                    alert('An error occurred while fetching user details.');
                }
            });

            // Approve user
            $('#approveBtn').off('click').on('click', function () {
                updateUserStatus(userId, 'Approved');
            });

            // Disapprove user
            $('#disapproveBtn').off('click').on('click', function () {
                updateUserStatus(userId, 'Rejected');
            });
        });

        function updateUserStatus(userId, status) {
            $.ajax({
                url: 'c_backend.php',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({ id: userId, status: status }),
                success: function (response) {
                    console.log(response);
                    if (response.status === "success") {
                        alert(response.message);
                        location.reload(); // Reload to reflect the updated status
                    } else {
                        alert(response.message || 'Failed to update user status.');
                    }
                },
                error: function () {
                    alert('An error occurred while updating user status.');
                }
            });
        }

        // Close modal
        $('#closeModal').on('click', function () {
            $('#userModal').css('display', 'none');
        });
    });
</script>
