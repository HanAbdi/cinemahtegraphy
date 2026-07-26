<nav x-data="{ mobileMenuOpen: false }"
    class="fixed top-0 left-0 w-full z-50 bg-[#0b0f19]/80 backdrop-blur-md border-b border-gray-800/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <div class="flex-shrink-0">
                <a href="#" class="text-2xl font-black tracking-widest text-white">
                    CINEMAH<span class="text-amber-500">TE</span>
                </a>
            </div>
            <div class="hidden md:block">
                <div class="ml-10 flex items-baseline space-x-8 text-sm font-medium tracking-wider uppercase">
                    <a href="{{ url('/') }}"
                        class="{{ Request::is('/') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Beranda</a>
                    <a href="{{ route('about') }}"
                        class="{{ Request::is('tentang') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Tentang</a>
                    <a href="{{ route('products') }}"
                        class="{{ Request::is('produk') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Produk</a>
                    <a href="{{ route('portfolios.index') }}"
                        class="{{ Request::is('portfolios') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Portofolio</a>
                    <a href="{{ route('faq') }}"
                        class="{{ Request::is('faq') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">FAQs</a>
                    <a href="{{ route('contact') }}"
                        class="bg-amber-500 text-black px-5 py-2.5 rounded-sm font-semibold hover:bg-amber-400 transition duration-300 transform hover:-translate-y-0.5">Hubungi
                        Kami</a>
                </div>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-btn" class="text-gray-400 hover:text-white focus:outline-none text-2xl">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-[#0c111d] border-b border-gray-800 px-4 pt-2 pb-6 flex flex-col space-y-3">
        <a href="{{ url('/') }}"
            class="{{ Request::is('/') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Beranda</a>
        <a href="{{ route('about') }}"
            class="{{ Request::is('tentang') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Tentang</a>
        <a href="{{ route('products') }}"
            class="{{ Request::is('produk') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Produk</a>
        <a href="{{ route('portfolios.index') }}"
            class="{{ Request::is('portfolios') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">Portofolio</a>
        <a href="{{ route('faq') }}"
            class="{{ Request::is('faq') ? 'text-amber-500' : 'text-gray-300' }} hover:text-amber-500 transition duration-300">FAQs</a>
        <a href="{{ route('contact') }}"
            class="bg-amber-500 text-black px-5 py-2.5 rounded-sm font-semibold hover:bg-amber-400 transition duration-300 transform hover:-translate-y-0.5">Hubungi
            Kami</a>
    </div>
</nav>