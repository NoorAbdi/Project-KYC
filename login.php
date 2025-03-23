<?php
session_start();
if(isset($SESSION['user_id'])){
  header('Location: index.php');
}
?>

<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYSys - Your best bank account manager!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="tailwind.js"></script>
    <link rel="stylesheet" href="style.css" />
</head>

<header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
      <div class="flex lg:flex-1">
        <a href="index.php" class="-m-1.5 p-1.5 flex items-center">
          <span class="sr-only">InfiniCore</span>
          <img class="h-8 w-auto" src="https://flowbite.com/docs/images/logo.svg" alt="">
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-kyc-second">InfiniCore</span>
        </a>
      </div>
      <div class="flex lg:hidden">
        <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
          <span class="sr-only">Open main menu</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
        </button>
      </div>
      <div class="hidden lg:flex lg:gap-x-12">
        <a href="index.php" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Home</a>
        <!-- <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">About</a>
        <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Marketplace</a>
        <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Company</a> -->
      </div>
      <div class="hidden relative lg:flex lg:flex-1 lg:justify-end">
        <a href="register.php">
            <button type="button" class="text-kyc-second bg-kyc-third hover:bg-kyc-prim focus:outline-none font-medium rounded-lg text-sm px-4 py-2 text-center">Create Account</button>
        </a>
    </div>
    </nav>
    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="lg:hidden" role="dialog" aria-modal="true">
      <!-- Background backdrop, show/hide based on slide-over state. -->
      <div class="fixed inset-0 z-50"></div>
      <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
        <div class="flex items-center justify-between">
          <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">InfiniCore</span>
            <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="">
          </a>
          <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
            <span class="sr-only">Close menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="mt-6 flow-root">
          <div class="-my-6 divide-y divide-gray-500/10">
            <div class="space-y-2 py-6">
              <a href="index.php" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Home</a>
              <!-- <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">About</a>
              <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Marketplace</a>
              <a href="#" class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Company</a> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>


<div class="flex min-h-screen items-center justify-center bg-[#1E1E1E]">
    <div class="container mx-auto p-4">
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-7 shadow-lg md:p-10">
            <h1 class="mb-8 text-center text-3xl font-bold">Log In Account</h1>

            <form id="loginform">
                <div class="step">
                    <div class="mb-6">
                        <label for="Email" class="mb-2 block text-sm font-medium text-gray-900">Email Address</label>
                        <input name="email" type="email" id="email"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            required />
                        <p id="error-message" class="mt-1 text-red-600"></p>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-900">Password</label>
                        <input name="password" type="password" id="password"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            required />
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <button type="submit" class="hover:cursor-pointer text-kyc-second bg-kyc-third hover:bg-kyc-prim focus:outline-none font-medium rounded-lg text-sm px-8 py-3 text-center">Log In</button>
                </div>
            </form>
            <p id="logvalidation" class="mt-1 text-red-600"></p>
        </div>
    </div>
</div>
<script>
        // Email validation helper function
        function validateEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        // Login form submission handler
        document.getElementById('loginform').addEventListener('submit', async function(event) {
            event.preventDefault(); // Prevent the form from reloading the page

            const emailInput = document.getElementById('email').value;
            const passwordInput = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');
            const responseOutput = document.getElementById('logvalidation');

            // Clear previous messages
            errorMessage.textContent = '';
            responseOutput.textContent = '';

            // Validate email format
            if (!validateEmail(emailInput)) {
                errorMessage.textContent = 'Please enter a valid email address.';
                return;
            }

            try {
                // Send GET request to API
                const response = await fetch(`auth/auth_api.php?for=login&email=${encodeURIComponent(emailInput)}&password=${encodeURIComponent(passwordInput)}`, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json"
                    }
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                // Parse and display the response
                const result = await response.json();
                if(result.status == 'success'){
                  alert("Log in success!")
                  document.cookie = "email =" + emailInput;
                  window.location.href = 'redirect.php';
                }else if(result.status == 'fail'){
                  logvalidation.textContent = "Invalid Email/Password credentials!";
                }
            } catch (error) {
                console.error("Error:", error);
            }
        });
    </script>
