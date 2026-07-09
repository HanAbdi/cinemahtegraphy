<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-heading font-bold text-gray-100">Manajemen Mitra Kerja (Logo Klien)</h2>
    </div>

    @if (session()->has('message'))
        <div class="relative overflow-hidden bg-[#1f2937] border-l-4 border-emerald-500 rounded-r-lg shadow-2xl mb-8" role="alert" x-data="{ show: true }" x-show="show" x-transition.duration.500ms>
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/10 to-transparent pointer-events-none"></div>
            <div class="p-4 flex items-center justify-between relative z-10">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 bg-emerald-500/20 w-10 h-10 flex items-center justify-center rounded-full border border-emerald-500/30">
                        <i class="fas fa-check text-emerald-400 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-emerald-400 uppercase tracking-wider mb-0.5">Sistem Diberbarui</h3>
                        <p class="text-sm text-gray-300 font-medium">{{ session('message') }}</p>
                    </div>
                </div>
                <button type="button" class="text-gray-500 hover:text-white transition-colors p-2" onclick="this.closest('[role=\'alert\']').remove()">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Form Upload -->
        <div class="lg:col-span-1">
            <div class="bg-[#1f2937] border border-gray-800 rounded-lg p-6 shadow-xl">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">Tambah Logo Baru</h3>
                
                <form wire:submit.prevent="save" class="space-y-4">
                    <div>
                        <label for="name" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Nama Perusahaan / Klien</label>
                        <input type="text" id="name" wire:model="name" required class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2.5 text-sm text-gray-100 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors">
                        @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label for="uploadedLogo" class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">File Logo (PNG/JPG)</label>
                        <input type="file" id="uploadedLogo" wire:model="uploadedLogo" accept="image/*" required class="w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-gray-300 hover:file:bg-gray-600 transition-colors">
                        <p class="text-[10px] text-gray-500 mt-2">Sebaiknya gunakan logo berformat PNG dengan latar transparan (maks 2MB).</p>
                        @error('uploadedLogo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    @if ($uploadedLogo)
                        <div class="mt-4 p-4 bg-[#111827] border border-gray-800 rounded-lg flex justify-center">
                            <img src="{{ $uploadedLogo->temporaryUrl() }}" class="max-h-20 object-contain">
                        </div>
                    @endif

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-black font-bold uppercase tracking-wider text-xs py-3 rounded-lg transition-colors shadow-lg shadow-amber-500/10">
                            Upload Logo
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- List Logos -->
        <div class="lg:col-span-2">
            <div class="bg-[#1f2937] border border-gray-800 rounded-lg p-6 shadow-xl h-full">
                <h3 class="text-lg font-bold text-white mb-4 border-b border-gray-700 pb-2">Daftar Logo Tersimpan</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    @forelse($logos as $item)
                        <div class="relative group aspect-video bg-[#1f2937] border border-gray-800 rounded-lg p-6 flex flex-col items-center justify-center hover:border-amber-500/50 transition-colors">
                            <img src="{{ Storage::url($item->logo_path) }}" alt="{{ $item->name }}" class="max-h-full max-w-full object-contain client-logo-filter">
                            <p class="mt-4 text-xs text-gray-400 font-medium text-center truncate w-full group-hover:text-amber-500 transition-colors">{{ $item->name }}</p>
                            
                            <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus logo ini?" class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200 hover:bg-red-600" title="Hapus">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </div>
                    @empty
                        <div class="col-span-full p-8 text-center text-gray-500">
                            Belum ada logo klien yang diunggah.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
