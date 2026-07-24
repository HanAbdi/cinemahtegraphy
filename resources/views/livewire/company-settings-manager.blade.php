<div class="p-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-black text-white uppercase tracking-tight">Kelola Informasi Kantor & Kontak</h1>
        </div>
    </div>

    @if($successMessage)
        <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3.5 rounded-xl text-xs font-medium flex items-center justify-between mb-6 shadow-lg shadow-emerald-500/5">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-base"></i>
                <span>{{ $successMessage }}</span>
            </div>
            <button wire:click="$set('successMessage', '')" class="text-emerald-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Form Section -->
        <div class="lg:col-span-7 bg-[#1f2937] border border-gray-800 rounded-2xl p-6 sm:p-8 shadow-xl">
            <form wire:submit.prevent="saveSettings" class="space-y-6">
                <!-- Alamat Utama -->
                <div>
                    <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">
                        <i class="fas fa-map-marker-alt text-amber-500 mr-1.5"></i> Alamat Utama Kantor
                    </label>
                    <textarea wire:model="office_address" rows="3" placeholder="Masukkan alamat lengkap kantor..." class="w-full bg-[#111827] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors" required></textarea>
                    @error('office_address') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Email & Phone Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">
                            <i class="fas fa-envelope text-amber-500 mr-1.5"></i> Email Korespondensi
                        </label>
                        <input type="email" wire:model="email" placeholder="info@cinemahtegraphy.com" class="w-full bg-[#111827] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors" required>
                        @error('email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">
                            <i class="fas fa-phone text-amber-500 mr-1.5"></i> Hotline / WhatsApp
                        </label>
                        <input type="text" wire:model="phone" placeholder="(+62) 812-3456-7890" class="w-full bg-[#111827] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors" required>
                        @error('phone') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Google Maps Embed Link -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="text-xs font-bold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-map-marked-alt text-amber-500 mr-1.5"></i> Embed URL / Kode Google Maps
                        </label>
                        <span class="text-[10px] text-gray-400">Tempel URL 'src' atau kode HTML &lt;iframe&gt;</span>
                    </div>
                    <textarea wire:model="maps_iframe_url" rows="3" placeholder="https://maps.google.com/maps?q=..." class="w-full bg-[#111827] border border-gray-700 rounded-xl px-4 py-3 text-xs font-mono text-gray-300 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors"></textarea>
                    <p class="text-[11px] text-gray-500 mt-1">Sistem otomatis mengekstrak tautan peta secara otomatis saat disimpan.</p>
                    @error('maps_iframe_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Social Media Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2 border-t border-gray-800">
                    <div>
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">
                            <i class="fab fa-instagram text-amber-500 mr-1.5"></i> Instagram URL
                        </label>
                        <input type="url" wire:model="instagram_url" placeholder="https://instagram.com/cinemahtegraphy" class="w-full bg-[#111827] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                        @error('instagram_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-300 uppercase tracking-wider mb-2">
                            <i class="fab fa-youtube text-amber-500 mr-1.5"></i> YouTube URL
                        </label>
                        <input type="url" wire:model="youtube_url" placeholder="https://youtube.com/cinemahtegraphy" class="w-full bg-[#111827] border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                        @error('youtube_url') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex justify-end">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-black font-bold uppercase tracking-wider text-xs px-8 py-3.5 rounded-xl transition duration-300 shadow-xl shadow-amber-500/20 flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-save"></i>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Live Preview Section -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-[#1f2937] border border-gray-800 rounded-2xl p-6 shadow-xl">
                <h3 class="text-sm font-bold uppercase text-white tracking-wider mb-4 flex items-center gap-2 pb-3 border-b border-gray-800">
                    <i class="fas fa-eye text-amber-500"></i>
                    <span>Live Preview Tampilan Publik</span>
                </h3>

                <div class="bg-[#0b0f19] border border-gray-900 rounded-xl p-6 space-y-6">
                    <h4 class="text-xs uppercase font-bold text-amber-500 tracking-wider">Informasi Kantor</h4>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-500/10 border border-amber-500/20 rounded-lg flex items-center justify-center text-amber-500 shrink-0 text-xs">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Alamat Utama</span>
                            <p class="text-xs text-gray-300 leading-relaxed font-light">{{ $office_address ?: 'Alamat belum diatur' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-500/10 border border-amber-500/20 rounded-lg flex items-center justify-center text-amber-500 shrink-0 text-xs">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Korespondensi Email</span>
                            <p class="text-xs text-gray-300 font-light">{{ $email ?: 'Email belum diatur' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-amber-500/10 border border-amber-500/20 rounded-lg flex items-center justify-center text-amber-500 shrink-0 text-xs">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <span class="text-[10px] uppercase font-bold text-gray-500 block mb-0.5">Hotline / WhatsApp</span>
                            <p class="text-xs text-gray-300 font-light">{{ $phone ?: 'Hotline belum diatur' }}</p>
                        </div>
                    </div>
                </div>

                @if($maps_iframe_url)
                    <div class="mt-4 aspect-video bg-gray-950 border border-gray-800 rounded-xl overflow-hidden shadow-inner">
                        <iframe src="{{ $maps_iframe_url }}" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
