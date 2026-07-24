<footer class="bg-[#060910] border-t border-gray-900 pt-20 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
        <div>
            <span class="text-xl font-black tracking-widest text-white block mb-6">CINEMAH<span
                    class="text-amber-500">TEGRAPHY</span></span>
            <p class="text-sm text-gray-400 font-light leading-relaxed mb-6">
                Membantu perusahaan mengukir identitas visual murni melalui tayangan sinematik yang bernilai tinggi.
            </p>
        </div>
        <div>
            <h4 class="text-sm font-bold uppercase tracking-widest text-amber-500 mb-6">Produk Populer</h4>
            <ul class="space-y-4">
                <li><a href="{{ route('products') }}" class="text-gray-400 hover:text-amber-500 transition duration-300">Company Profile</a></li>
                <li><a href="{{ route('products') }}" class="text-gray-400 hover:text-amber-500 transition duration-300">Video Promosi</a></li>
                <li><a href="{{ route('products') }}" class="text-gray-400 hover:text-amber-500 transition duration-300">Drone FPV</a></li>
                <li><a href="#" class="hover:text-amber-400 transition">Custom Project Video</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-sm font-bold uppercase tracking-widest text-amber-500 mb-6">Kontak Kantor</h4>
            <address class="text-sm text-gray-400 font-light not-italic space-y-3">
                <p><i class="fas fa-map-marker-alt text-amber-500 mr-2.5"></i> {{ $companySettings->office_address }}</p>
                <p><i class="fas fa-envelope text-amber-500 mr-2.5"></i> {{ $companySettings->email }}</p>
                <p><i class="fas fa-phone text-amber-500 mr-2.5"></i> {{ $companySettings->phone }}</p>
            </address>
        </div>
        <div>
            <h4 class="text-sm font-bold uppercase tracking-widest text-amber-500 mb-6">Social Media</h4>
            <div class="flex items-center space-x-4">
                <a href="{{ $companySettings->instagram_url ?: '#' }}" target="_blank"
                    class="w-10 h-10 rounded-full bg-[#0f1524] flex items-center justify-center text-gray-400 hover:text-black hover:bg-amber-500 transition duration-300 text-lg"><i
                        class="fab fa-instagram"></i></a>
                <a href="{{ $companySettings->youtube_url ?: '#' }}" target="_blank"
                    class="w-10 h-10 rounded-full bg-[#0f1524] flex items-center justify-center text-gray-400 hover:text-black hover:bg-amber-500 transition duration-300 text-lg"><i
                        class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 border-t border-gray-900 flex flex-col sm:flex-row items-center justify-between text-xs text-gray-500">
        <p>&copy; PT. CINEMAHTEGRAPHY | All Rights Reserved.</p>
    </div>
</footer>

<script>
    // Vanilla JS for Hamburger Menu Toggle
    const menuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        const icon = menuBtn.querySelector('i');
        if (mobileMenu.classList.contains('hidden')) {
            icon.className = 'fas fa-bars';
        } else {
            icon.className = 'fas fa-xmark';
        }
    });
</script>