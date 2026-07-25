<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Anril Film | Website Portofolio Videografer')</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/img/logo.png') }}">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading {
            font-family: 'Montserrat', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0b0f19;
        }

        ::-webkit-scrollbar-thumb {
            background: #1e293b;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #f59e0b;
        }

        .client-logo-filter {
            filter: brightness(0) invert(1);
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .client-logo-filter:hover {
            filter: none;
            opacity: 1;
        }

        @keyframes marquee-ltr {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0%);
            }
        }

        .animate-marquee-ltr {
            animation: marquee-ltr 40s linear infinite;
            will-change: transform;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-[#0b0f19] text-gray-100 font-sans selection:bg-amber-500 selection:text-black">

    @include('partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <livewire:visitor-chat-widget />

    @stack('scripts')
</body>

</html>