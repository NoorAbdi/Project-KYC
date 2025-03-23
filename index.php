<!DOCTYPE html>
<html lang="en">

<head>
    <link href="{{ asset('style.css') }}" rel="stylesheet" type="text/css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KYSys - Your best bank account manager!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="tailwind.js"></script>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .swiper-container,
        .swiper-slide {
            width: 100vw;
            height: 100vh;
        }

        /* Custom pagination on the right side */
        .swiper-pagination {
            right: 10px;
            left: auto;
            text-align: right;
        }

        .section-1 {
            background-color: rgb(30, 41, 59);
            background-image: radial-gradient(at 52.16% 32.50%, rgb(30, 41, 59) 0, transparent 94%), radial-gradient(at 7.13% 11.00%, rgb(30, 41, 59) 0, transparent 59%), radial-gradient(at 94.63% 10.33%, rgb(15, 23, 42) 0, transparent 88%), radial-gradient(at 95.52% 93.50%, rgb(30, 58, 138) 0, transparent 95%), radial-gradient(at 5.14% 91.67%, rgb(30, 58, 138) 0, transparent 94%), radial-gradient(at 51.71% 54.33%, rgb(163, 163, 163) 0, transparent 57%);
        }
    </style>
</head>

<body>
    <!-- Nav bar -->
    <header class="absolute inset-x-0 top-0 z-50">
        <nav class="flex items-center justify-between p-6 lg:px-8" aria-label="Global" x-data="{ isOpen: false }">
            <div class="flex lg:flex-1">
                <a href="#" class="-m-1.5 p-1.5 flex items-center">
                    <span class="sr-only">InfiniCore</span>
                    <img class="h-8 w-auto" src="https://flowbite.com/docs/images/logo.svg" alt="">
                    <span
                        class="self-center text-2xl font-semibold whitespace-nowrap dark:text-kyc-second">InfiniCore</span>
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" @click="isOpen = !isOpen"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Home</a>
                <!-- <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">About</a>
                <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Marketplace</a>
                <a href="#" class="font-medium leading-6 text-kyc-second md:hover:text-kyc-third">Company</a> -->
            </div>
            <div class="hidden relative lg:flex lg:flex-1 lg:justify-end">
                <div class="flex">
                    <a href="login.php" class="flex font-medium leading-6 text-kyc-second md:hover:text-kyc-third">
                        Log-In Account
                        <svg class="ml-2 w-6 h-6 md:hover:text-kyc-third" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                    </svg>
                    </a>
                </div>
            </div>
            </div>
        </nav>
        <!-- Mobile menu, show/hide based on menu open state. -->
        <div x-show="isOpen" class="lg:hidden" role="dialog" aria-modal="true">
            <!-- Background backdrop, show/hide based on slide-over state. -->
            <div class="hidden fixed inset-0 z-50"></div>
            <div :class="{'hidden': isOpen, 'block': !isOpen }"
                class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                <div class="flex items-center justify-between">
                    <a href="#" class="-m-1.5 p-1.5">
                        <span class="sr-only">InfiniCore</span>
                        <img class="h-8 w-auto"
                            src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600" alt="">
                    </a>
                    <button @click="isOpen = !isOpen" type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mt-6 flow-root">
                    <div class="-my-6 divide-y divide-gray-500/10">
                        <div class="space-y-2 py-6">
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Home</a>
                            <!-- <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">About</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Marketplace</a>
                            <a href="#"
                                class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Company</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Body contents -->
    <!-- Swiper Container -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <!-- Slide 1: Red -->
            <section class="bg-kyc-prim/90 h-screen flex items-center section-1 swiper-slide">
                <div class="inset-0 px-4 m-auto mx-auto mt-16 mb-16 max-w-7xl sm:mt-24 items-center justify-center">
                    <div class="text-center">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-200 sm:text-5xl md:text-6xl font-title">
                            <span class="block">Your All-in-one bank</span>
                            <span class="block pt-2">account manager</span>
                        </h1>
                        <p
                            class="max-w-md mx-auto mt-3 text-base text-gray-300 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            Our platform is your all-in-one bank account manager, streamlining account management,
                            enhancing customer experience, and ensuring seamless financial operations.
                        </p>
                        <div class="max-w-md mx-auto mt-5 sm:flex sm:justify-center md:mt-8">

                            <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                                <a href=""
                                    class="block shadow-lg w-full px-8 py-3 text-base font-medium text-gray-200 hover:text-gray-100 bg-kyc-third hover:bg-[#0000c6] hover:backdrop-blur-xl backdrop-blur-lg rounded-md md:py-4 md:text-lg md:px-10">
                                    LEARN MORE
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="custom-shape-divider-bottom-1728817602">
                    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                        preserveAspectRatio="none">
                        <path
                            d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
                            class="shape-fill"></path>
                    </svg>
                </div>
            </section>
            <!-- Slide 2: Blue -->
            <section
                class="bg-gradient-to-t from-slate-800 via-slate-800 to-blue-800 h-screen flex flex-col items-center relative section-2 swiper-slide">
                <div class="inset-0 px-4 m-auto mx-auto mt-16 mb-16 max-w-7xl sm:mt-24 items-center justify-center">
                    <div class="custom-shape-divider-top-1728833559">
                        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120"
                            preserveAspectRatio="none">
                            <path
                                d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z"
                                class="shape-fill"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-40 w-full flex flex-col">
                    <div class="flex justify-center space-x-20">
                        <div class="flex w-64 flex-col items-center text-center">
                            <div class="m-4 box-content h-28 w-32 bg-[#3431f8] p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-white">Fast</h1>
                            <p class="text-lg text-white">Our platform accelerates the KYC process, enabling banks to
                                onboard customers quickly and efficiently.</p>
                        </div>
                        <div class="flex w-64 flex-col items-center text-center">
                            <div class="m-4 box-content h-28 w-32 bg-[#3431f8] p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-white">Reliable</h1>
                            <p class="text-lg text-white">With robust technology and accurate data handling, we provide
                                consistent and dependable results you can trust.</p>
                        </div>
                        <div class="flex w-64 flex-col items-center text-center">
                            <div class="m-4 box-content h-28 w-32 bg-[#3431f8] p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="white">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold text-white">Secure</h1>
                            <p class="text-lg text-white">Built with advanced security protocols, we safeguard your data
                                to ensure the highest level of protection.</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-7xl font-bold text-center text-white mt-10">What are you<br>waiting for?</h1>
                        <div class="m-2 rounded-md shadow mt-8">
                            <a href="register.php"
                                class="block shadow-lg w-full px-8 py-2 text-base font-medium text-gray-200 hover:text-gray-100 border border-kyc-third hover:bg-kyc-third hover:backdrop-blur-xl backdrop-blur-lg rounded-md md:py-2 md:text-lg md:px-10">
                                Create an account now
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Slide 3: Green -->
            <section class="bg-gradient-to-t from-blue-800 via-slate-800 to-slate-800 bg-kyc-prim/90 swiper-slide">
                <div
                    class="mt-60 relative mx-auto flex flex-col items-center lg:max-w-5xl lg:flex-row-reverse xl:max-w-6xl">
                    <div class="h-68 w-full lg:h-auto lg:w-3/4">
                        <img class="h-full w-full object-cover ml-40 mt-4"
                            src="https://mrwallpaper.com/images/hd/contract-documents-with-laptop-ggy441x5ml83d64y.jpg"
                            alt="Winding mountain road" />
                    </div>
                    <div
                        class="max-w-lg bg-white md:absolute md:top-0 md:z-10 md:mt-48 md:max-w-2xl md:shadow-lg lg:left-0 lg:ml-20 lg:mt-20 lg:w-3/5 xl:ml-12 xl:mt-24">
                        <div class="flex flex-col p-12 md:px-16">
                            <h2 class="text-2xl font-medium uppercase text-kyc-prim lg:text-4xl">About Us</h2>
                            <p class="mt-4">We are a trusted partner in revolutionizing the KYC process for banks,
                                combining cutting-edge technology with deep industry expertise. Our platform simplifies
                                customer onboarding and verification, ensuring compliance with global regulatory
                                standards while enhancing efficiency and customer experience. With a commitment to
                                security, innovation, and excellence, we empower banks to build stronger, safer, and
                                more transparent relationships with their customers.</p>
                            <div class="mt-8">
                                <a href="#"
                                    class="inline-block w-full border-2 border-solid border-gray-600 bg-kyc-third px-10 py-4 text-center text-lg font-medium text-gray-100 hover:bg-[#0000c6] hover:shadow-md md:w-48">Read
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>


        </div>
        </section>
        <!-- Slide 4: Yellow -->
        <section class="swiper-slide bg-yellow-500">Section 4</section>
        <!-- Slide 5: Purple -->
        <section class="swiper-slide bg-purple-500">Section 5</section>
    </div>

    <!-- Pagination Dots -->
    <div class="swiper-pagination"></div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper('.swiper-container', {
            direction: 'vertical', // Vertical scrolling
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            mousewheel: true, // Enable mousewheel scroll navigation
            keyboard: {
                enabled: true, // Enable keyboard navigation (arrow keys)
            },
        });
    </script>

</body>

</html>