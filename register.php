<?php
session_start();
if(isset($SESSION['user_id'])){
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYSys - Your best bank account manager!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="tailwind.js"></script>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header class="absolute inset-x-0 top-0 z-50">
    <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="index.php" class="-m-1.5 p-1.5 flex items-center">
                <img class="h-8 w-auto" src="https://flowbite.com/docs/images/logo.svg" alt="">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-kyc-second">InfiniCore</span>
            </a>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="index.php" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Home</a>
            <!-- <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">About</a>
            <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Marketplace</a>
            <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Company</a> -->
        </div>
        <div class="hidden relative lg:flex lg:flex-1 lg:justify-end">
            <a href="login.php">
                <button type="button"
                    class="text-kyc-second bg-kyc-third hover:bg-kyc-prim focus:outline-none font-medium rounded-lg text-sm px-4 py-2 text-center">Log
                    In
                    Account</button>
            </a>
        </div>
    </nav>
</header>

<div class="flex min-h-screen items-center justify-center bg-[#1E1E1E]">
    <div class="container mx-auto p-4">
        <div class="mx-auto max-w-3xl rounded-lg bg-white p-7 shadow-lg md:p-10">
            <h1 class="mb-8 text-center text-3xl font-bold">Create Account</h1>

            <form id="registerform">
                <div class="step">
                    <div class="mb-6">
                        <label for="email" class="mb-2 block text-sm font-medium text-gray-900">Email Address</label>
                        <input name="email" type="email" id="email"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            required />
                        <p id="message0" class="mt-1 text-red-600"></p>
                    </div>
                    <div class="mb-6">
                        <label for="password" class="mb-2 block text-sm font-medium text-gray-900">Password</label>
                        <input name="password" type="password" id="password"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            required />
                        <p id="message1" class="mt-1 text-yellow-600"></p>
                    </div>
                    <div class="mb-6">
                        <label for="confirmPassword" class="mb-2 block text-sm font-medium text-gray-900">Confirm Password</label>
                        <input name="confirmPassword" type="password" id="confirmPassword"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:border-green-500 focus:ring-green-500"
                            required />
                        <p id="message2" class="mt-1 text-red-600"></p>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <button type="submit"
                        class="hover:cursor-pointer text-kyc-second bg-kyc-third hover:bg-kyc-prim focus:outline-none font-medium rounded-lg text-sm px-8 py-3 text-center">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<script>
    document.getElementById('registerform').addEventListener('submit', async function (event) {
        event.preventDefault();
        const emailInput = document.getElementById('email').value;
        const passwordInput = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        const emailMessage = document.getElementById('message0');
        const passwordMessage = document.getElementById('message1');
        const confirmPasswordMessage = document.getElementById('message2');

        // Clear previous messages
        emailMessage.textContent = '';
        passwordMessage.textContent = '';
        confirmPasswordMessage.textContent = '';

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

        // Validate email
        if (!emailRegex.test(emailInput)) {
            emailMessage.textContent = 'Please enter a valid email address.';
            return;
        }

        // Validate password
        if (!passwordRegex.test(passwordInput)) {
            passwordMessage.textContent = 'Password must be at least 8 characters, include uppercase, lowercase, a number, and a special character.';
            return;
        }

        // Check if passwords match
        if (passwordInput !== confirmPassword) {
            confirmPasswordMessage.textContent = 'Passwords do not match.';
            return;
        }

        try {
            // Send POST request to API
            const response = await fetch('auth/auth_api.php',{
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    email: emailInput,
                    password: passwordInput
                })
            });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Error: ${errorText}`);
            }

            // Parse and display the response
            const result = await response.json();

            if(result.status == 'success'){
                alert("Registration successful!");
                window.location.href = 'login.php';
            } else {
                alert(result.message);
            }
        } catch (error) {
             console.error("Error:", error);
        }
    });
</script>