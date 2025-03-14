<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="font-[sans-serif]">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 items-center gap-4 min-h-screen bg-gray-100">
            <div class="max-md:order-1 lg:col-span-2 md:h-full w-full bg-white md:rounded-tr-xl md:rounded-br-xl lg:p-12 p-8 hidden sm:block">
                <img src="https://readymadeui.com/signin-image.webp" class="lg:w-[70%] w-full h-full object-contain block mx-auto" alt="login-image" />
            </div>

            <div class="w-full p-6 h-full">
                <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 h-full">
                    <div>
                        <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a>
                    </div>

                    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>