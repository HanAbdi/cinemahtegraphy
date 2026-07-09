<div>
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h2 class="text-2xl font-heading font-bold text-gray-100">Manajemen Portofolio</h2>
        <div class="flex items-center gap-3">
            <select wire:model.live="sortOption" class="custom-select bg-[#111827] text-sm text-gray-300 border border-gray-700 rounded-lg pl-3 pr-10 py-2.5 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-colors cursor-pointer">
                <option value="year_asc_newest">Tahun Terkecil ke Terbesar (Default)</option>
                <option value="year_desc">Tahun Terbesar ke Terkecil</option>
                <option value="newest">List Terbaru Ditambahkan</option>
                <option value="oldest">List Terlama Ditambahkan</option>
            </select>
            
            <a href="{{ route('admin.portfolios.create') }}" class="bg-amber-500 hover:bg-amber-600 text-black font-semibold py-2.5 px-4 rounded-lg flex items-center gap-2 transition-colors">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden shadow-lg">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#111827] text-gray-400 text-sm border-b border-gray-800">
                        <th class="p-4 font-semibold">Judul & Klien</th>
                        <th class="p-4 font-semibold">Kategori</th>
                        <th class="p-4 font-semibold text-center">Tahun</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-800">
                    @forelse($portfolios as $item)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-12 rounded bg-gray-800 overflow-hidden shrink-0">
                                        @if($item->image_path)
                                            <img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-600">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-100 flex items-center gap-2">
                                            {{ $item->title }}
                                            @if($item->project_scope)
                                                <span class="{{ $item->tag_scheme === 'B' ? 'bg-blue-500/10 text-blue-500' : 'bg-amber-500/10 text-amber-500' }} text-[10px] px-2 py-0.5 rounded-full uppercase tracking-wider font-bold">{{ $item->project_scope }}</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $item->client }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-gray-300">
                                {{ $item->category }}
                                <div class="text-xs text-gray-500 mt-1">{{ $item->service_type }}</div>
                            </td>
                            <td class="p-4 text-center text-gray-400">{{ $item->year }}</td>
                            <td class="p-4 text-right">
                                <a href="{{ route('admin.portfolios.edit', $item->id) }}" class="inline-block text-amber-500 hover:text-amber-400 p-2 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button wire:click="confirmDelete({{ $item->id }})" class="text-red-400 hover:text-red-300 p-2 transition-colors">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-gray-500">
                                Belum ada portofolio yang ditambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>



    <!-- Delete Confirm Modal -->
    @if($isConfirmDeleteOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
        <div class="bg-[#1f2937] border border-gray-800 rounded-xl shadow-2xl p-6 max-w-sm w-full text-center">
            <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-lg font-bold text-white mb-2">Hapus Portofolio?</h3>
            <p class="text-gray-400 text-sm mb-6">Tindakan ini tidak dapat dibatalkan. Gambar yang terkait juga akan dihapus dari server.</p>
            <div class="flex gap-3 justify-center">
                <button wire:click="$set('isConfirmDeleteOpen', false)" class="px-4 py-2 text-sm font-medium text-gray-300 hover:bg-gray-800 rounded-lg transition-colors">Batal</button>
                <button wire:click="delete" class="px-4 py-2 text-sm font-medium bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
