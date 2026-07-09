<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Cinemahtegraphy</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tiny.cloud/1/u0tixvzi7hmo64x54tptfuyepbqssg1284ufe4b30jltivpv/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        
        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: 'Montserrat', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        .custom-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1.25rem center;
            background-repeat: no-repeat;
            background-size: 1.25em 1.25em;
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
    </style>
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-[#0b0f19] text-gray-100 font-sans selection:bg-amber-500 selection:text-black flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-[#111827] border-r border-gray-800 flex flex-col justify-between hidden md:flex">
        <div>
            <div class="h-16 flex items-center px-6 border-b border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="text-xl font-heading font-bold tracking-wider">
                    <span class="text-white">ADMIN</span><span class="text-amber-500">PANEL</span>
                </a>
            </div>
            
            <nav class="flex-1 mt-6 px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <i class="fas fa-chart-line w-6"></i>
                    Dashboard
                </a>
                
                @php
                    $perms = auth()->user()->permissions ?? [];
                    $isSuper = auth()->user()->role === 'superadmin';
                @endphp

                @if($isSuper || in_array('portofolio', $perms))
                <a href="{{ route('admin.portfolios.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.portfolios.*') ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <i class="fas fa-briefcase w-6"></i>
                    Portofolio
                </a>
                @endif

                @if($isSuper || in_array('penawaran', $perms))
                @livewire('admin-notification-penawaran', key('badge-penawaran'))
                @endif

                @if($isSuper || in_array('mitra_kerja', $perms))
                <a href="{{ route('admin.client-logos.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.client-logos.*') ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-colors' }}">
                    <i class="fas fa-handshake w-6"></i>
                    Mitra Kerja
                </a>
                @endif

                @if($isSuper || in_array('live_chat', $perms))
                @livewire('admin-notification-chat', key('badge-chat'))
                @endif

                @if($isSuper)
                <div class="pt-4 mt-4 border-t border-gray-800">
                    <p class="px-4 text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Super Admin</p>
                    <a href="{{ route('admin.accounts.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.accounts.*') ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-colors' }}">
                        <i class="fas fa-users-cog w-6"></i>
                        Manajemen Akun
                    </a>
                </div>
                @endif

                <div class="pt-4 mt-4 border-t border-gray-800">
                    <a href="{{ url('/') }}" target="_blank" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-400 hover:bg-gray-800 hover:text-white transition-colors">
                        <i class="fas fa-external-link-alt w-6"></i>
                        Lihat Website
                    </a>
                </div>
            </nav>
        </div>
        
        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden">
        <!-- Topbar -->
        <header class="h-16 bg-[#111827] border-b border-gray-800 flex items-center justify-between px-6 z-10">
            <!-- Mobile Menu Button -->
            <button class="md:hidden text-gray-400 hover:text-white">
                <i class="fas fa-bars text-xl"></i>
            </button>
            
            <div class="hidden md:block">
                <!-- Empty space or breadcrumbs -->
            </div>
            
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-sm text-gray-400">
                    <i class="fas fa-user-circle text-xl"></i>
                    <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>
</html>
