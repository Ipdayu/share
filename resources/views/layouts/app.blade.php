@php
    // resources/views/layouts/app.blade.php
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sharing Page BUDUTWJ') }}</title>

    <!-- Dark Mode Init -->
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Poppins Font -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/poppins@latest/index.css" />

    <!-- Google Fonts for Elegant Titles -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700;800&family=Montserrat:wght@500;700;800&family=Cinzel:wght@500;700;800&family=Dancing+Script:wght@600;700&family=Great+Vibes&display=swap"
        rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS via CDN for rapid prototyping if not compiled -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Poppins', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body
    class="min-h-screen flex flex-col font-sans text-gray-900 dark:text-gray-100 bg-[#f3f4f6] dark:bg-gray-900 relative">

    <!-- Fix for mobile background-attachment issue -->
    @if(file_exists(public_path('bg.jpg')))
        <div class="fixed inset-0 w-full h-full z-[-2]" style="
                                background-image: url('{{ asset('bg.jpg') }}?v={{ time() }}');
                                background-size: cover;
                                background-position: center;
                                background-repeat: no-repeat;
                            "></div>
        <div class="fixed inset-0 bg-black/30 backdrop-blur-[2px] z-[-1] w-full h-full"></div>
    @endif

    <main class="flex-1 w-full relative z-10">
        @if (session('success'))
            <div class="max-w-[480px] mx-auto mt-4 px-4">
                <div class="bg-green-100 text-green-800 p-3 rounded-lg shadow-sm text-sm text-center">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @yield('content')
    </main>
</body>

</html>