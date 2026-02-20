<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}
    </title>

    <link rel="icon" type="image/x-icon" href="/images/dibuatinIcon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-white-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <!-- @isset($header)
    <header class="bg-white shadow">
                                        <div
                                            class="max-w-9xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                            {{ $header }}
                                        </div>
                                    </header>
@endisset -->

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <footer class="mx-20">
        <div class="flex justify-end my-8">
            <div class="w-full">
                <h3 class="text-2xl font-bold">
                    Subscribe to our newsletter
                </h3>
                <p class="text-lg">Find out what
                    we do every week</p>
            </div>
            <input
                class="rounded-xl w-2/5 h-10 my-2 mr-2 text-sm border-gray-200 placeholder-gray-300 border-2 bg-transparent active:border-gray-400 focus:border-gray-400 focus:outline-none"
                placeholder="Insert your email" type="email">
            <button
                class="bg-[#FF7800] hover:bg-[#da6600] rounded-xl h-10 my-2 px-4 text-white text-sm">Subscribe</button>
        </div>
        <hr>
        <div class="flex justify-end text-gray-700 items-center my-8">
            <div class="w-full">
                <img src="/images/logo.png" style="margin-left: -0.8rem">
                <p>Lorem Ipsum, 235 Simply,
                    printing, Pin 309 309</p>
                <p>dibuatin.gmail.com</p>
                <p>+62 80005 54442</p>
            </div>
            <div class="grid grid-cols-3 mr-10 gap-28">
                <div class="text-black text-nowrap ">
                    <p class="text-gray-700 font-bold mb-3">
                        Information</p>
                    <p>Home</p>
                    <p>About Us</p>
                    <p>Services</p>
                    <p>Gallery</p>
                </div>
                <div class="text-black text-nowrap">
                    <p class="text-gray-700 font-bold mb-3">
                        Services</p>
                    <p>Short Video Ads</p>
                    <p>Adverstising Design</p>
                </div>
                <div class="text-black text-nowrap ">
                    <p class="text-gray-700 font-bold mb-3">
                        Support</p>
                    <p>Help Center</p>
                    <p>FAQ</p>
                    <p>News</p>
                    <p>Career</p>
                    <p>Terms of Use</p>
                </div>
            </div>
        </div>
        <hr>
        <div class="flex justify-end my-8 text-xs">
            <p class="w-full">&copy 2020 Dibuatin
                Inc.</p>
            <p class="text-nowrap">Privacy Policy
                | Terms & Conditions | Cookies</p>
        </div>
    </footer>
</body>

</html>
