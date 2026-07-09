<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login - {{ config('app.name', 'Cinemahtegraphy') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Icons & Tailwind via CDN for consistency with admin-layout -->
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap');
            
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            
            h1, h2, h3, h4, h5, h6, .font-heading {
                font-family: 'Montserrat', sans-serif;
            }
        </style>
    </head>
    <body class="bg-[#0b0f19] text-gray-100 antialiased selection:bg-amber-500 selection:text-black">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#0b0f19] relative overflow-hidden">
            
            <!-- Subtle background accents -->
            <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="z-10 text-center mb-8">
                <a href="/" class="text-3xl font-heading font-bold tracking-wider inline-block">
                    <span class="text-white">ADMIN</span><span class="text-amber-500">PANEL</span>
                </a>
                <p class="text-gray-400 mt-2 text-sm">Masuk untuk mengelola Cinemahtegraphy</p>
            </div>

            <div class="w-full sm:max-w-md px-8 py-8 bg-[#111827] border border-gray-800 shadow-2xl overflow-hidden sm:rounded-2xl z-10 relative">
                <!-- Top accent line -->
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500/0 via-amber-500 to-amber-500/0 opacity-50"></div>
                
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-xs text-gray-600 z-10">
                &copy; {{ date('Y') }} Cinemahtegraphy. All rights reserved.
            </div>
        </div>
    </body>
</html>
