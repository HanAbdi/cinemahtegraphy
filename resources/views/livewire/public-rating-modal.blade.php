<div>
    @if($isOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-[#111827] border border-gray-800 rounded-2xl shadow-2xl max-w-lg w-full p-6 sm:p-8 relative">
            
            <!-- Close Button -->
            <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-white text-xl transition-colors">
                <i class="fas fa-times"></i>
            </button>

            <!-- Header -->
            <div class="text-center mb-6">
                <div class="w-12 h-12 bg-amber-500/10 border border-amber-500/20 text-amber-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
                    <i class="fas fa-star"></i>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold uppercase text-white tracking-wider">Beri Ulasan & Rating</h3>
                <p class="text-xs text-gray-400 mt-1 font-light">Bagikan pengalaman Anda bekerja sama dengan CINEMAHTEGRAPHY.</p>
            </div>

            @if($successMessage)
                <div class="bg-amber-500/10 border border-amber-500/30 text-amber-400 p-4 rounded-xl text-xs leading-relaxed text-center mb-4">
                    <i class="fas fa-check-circle text-lg mb-1 block"></i>
                    {{ $successMessage }}
                </div>
                <div class="text-center mt-6">
                    <button wire:click="closeModal" class="px-6 py-2.5 bg-amber-500 text-black font-bold uppercase text-xs rounded-lg hover:bg-amber-400 transition">
                        Tutup Window
                    </button>
                </div>
            @else
                <form wire:submit.prevent="submitRating" class="space-y-4">
                    <!-- Honeypot Bot Trap -->
                    <input type="text" wire:model="website_url" class="absolute opacity-0 -z-10" tabindex="-1" autocomplete="off">

                    <!-- Rating Stars Selection -->
                    <div class="text-center">
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Pilih Rating Bintang</label>
                        <div class="flex items-center justify-center gap-2">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" wire:click="setRating({{ $i }})" class="text-3xl transition-transform hover:scale-110 focus:outline-none">
                                    <i class="fas fa-star {{ $i <= $rating ? 'text-amber-400' : 'text-gray-700' }}"></i>
                                </button>
                            @endfor
                        </div>
                        <span class="text-xs text-amber-400 font-bold mt-1 block">{{ $rating }} dari 5 Bintang</span>
                    </div>

                    <!-- Client Name -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap / Instansi</label>
                        <input type="text" wire:model="client_name" placeholder="Misal: Budi Santoso" class="w-full bg-[#1f2937] border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors" required>
                        @error('client_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Client Company/Role -->
                        <div>
                            <div class="flex items-center justify-between mb-1 h-5">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perusahaan / Jabatan</label>
                                <span class="text-[10px] text-gray-500 font-normal lowercase">(opsional)</span>
                            </div>
                            <input type="text" wire:model="client_company" placeholder="Misal: PT Unilever" class="w-full bg-[#1f2937] border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                            @error('client_company') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Client Email (Optional) -->
                        <div>
                            <div class="flex items-center justify-between mb-1 h-5">
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Alamat Email</label>
                                <span class="text-[10px] text-gray-500 font-normal lowercase">(opsional)</span>
                            </div>
                            <input type="email" wire:model="client_email" placeholder="budi@example.com" class="w-full bg-[#1f2937] border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                            @error('client_email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Client Avatar / Photo Upload (Optional) -->
                    <div>
                        <div class="flex items-center justify-between mb-1 h-5">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Foto Profil / Logo Klien</label>
                            <span class="text-[10px] text-gray-500 font-normal lowercase">(opsional)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="file" wire:model="avatar" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500/10 file:text-amber-400 hover:file:bg-amber-500/20 cursor-pointer">
                            @if($avatar)
                                <img src="{{ $avatar->temporaryUrl() }}" class="w-10 h-10 rounded-full object-cover border border-amber-500/40 shrink-0">
                            @endif
                        </div>
                        @error('avatar') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Review Text -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Ulasan Pengalaman Anda</label>
                        <textarea wire:model="review" rows="3" placeholder="Tuliskan impresi Anda terhadap kualitas video, komunikasi kru, atau ketepatan waktu proyek..." class="w-full bg-[#1f2937] border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors" required></textarea>
                        @error('review') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    @error('rate_limit')
                        <div class="text-red-400 text-xs text-center bg-red-500/10 border border-red-500/20 py-2 rounded-lg">
                            {{ $message }}
                        </div>
                    @enderror

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-400 text-black font-bold uppercase tracking-wider text-xs py-3 rounded-lg transition duration-300 flex items-center justify-center gap-2">
                            <span>Kirim Ulasan</span>
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @endif
</div>
