<div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-heading font-bold text-gray-100">Manajemen Ulasan & Rating</h2>
        </div>
        
        <button wire:click="openForm" class="bg-amber-500 hover:bg-amber-600 text-black font-semibold py-2.5 px-4 rounded-lg flex items-center gap-2 transition-colors shrink-0">
            <i class="fas fa-plus"></i>
            <span>Tambah Testimoni Resmi</span>
        </button>
    </div>

    <!-- Filter Tabs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <button wire:click="setTab('pending')" class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-colors {{ $activeTab === 'pending' ? 'bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/10' : 'bg-[#1f2937] text-gray-400 hover:text-white' }}">
            <i class="fas fa-clock"></i>
            <span>Menunggu Moderasi</span>
            @if($pendingCount > 0)
                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $pendingCount }}</span>
            @endif
        </button>

        <button wire:click="setTab('approved')" class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-colors {{ $activeTab === 'approved' ? 'bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/10' : 'bg-[#1f2937] text-gray-400 hover:text-white' }}">
            <i class="fas fa-check-circle"></i>
            <span>Disetujui</span>
            <span class="bg-gray-800 text-gray-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $approvedCount }}</span>
        </button>

        <button wire:click="setTab('rejected')" class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-colors {{ $activeTab === 'rejected' ? 'bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/10' : 'bg-[#1f2937] text-gray-400 hover:text-white' }}">
            <i class="fas fa-times-circle"></i>
            <span>Ditolak</span>
            <span class="bg-gray-800 text-gray-300 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $rejectedCount }}</span>
        </button>

        <button wire:click="setTab('all')" class="px-4 py-2 rounded-lg text-xs font-semibold flex items-center gap-2 transition-colors {{ $activeTab === 'all' ? 'bg-amber-500 text-black font-bold shadow-lg shadow-amber-500/10' : 'bg-[#1f2937] text-gray-400 hover:text-white' }}">
            <i class="fas fa-list"></i>
            <span>Semua Ulasan</span>
        </button>
    </div>

    <!-- Table -->
    <div class="bg-[#1f2937] border border-gray-800 rounded-xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#111827] text-gray-400 text-xs uppercase tracking-wider border-b border-gray-800">
                        <th class="p-4 font-semibold">Klien & Perusahaan</th>
                        <th class="p-4 font-semibold text-center">Rating</th>
                        <th class="p-4 font-semibold">Ulasan</th>
                        <th class="p-4 font-semibold text-center">Status</th>
                        <th class="p-4 font-semibold text-center">Beranda</th>
                        <th class="p-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm divide-y divide-gray-800">
                    @forelse($testimonials as $item)
                        <tr class="hover:bg-gray-800/50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @if($item->avatar_path)
                                        <img src="{{ asset('storage/' . $item->avatar_path) }}" class="w-10 h-10 rounded-full object-cover border border-amber-500/30 shrink-0">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 font-bold flex items-center justify-center text-xs shrink-0">
                                            {{ substr($item->client_name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="font-semibold text-white">{{ $item->client_name }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $item->client_company ?: 'Klien Umum' }}</div>
                                        @if($item->client_email)
                                            <div class="text-[10px] text-amber-400/80">{{ $item->client_email }}</div>
                                        @endif
                                        <div class="text-[10px] text-gray-500 mt-0.5 font-mono">IP: {{ $item->ip_address ?: 'Admin Entry' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex justify-center items-center gap-0.5 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-xs {{ $i <= $item->rating ? 'text-amber-400' : 'text-gray-700' }}"></i>
                                    @endfor
                                </div>
                                <span class="text-xs font-bold text-gray-300 mt-0.5 block">{{ $item->rating }}.0</span>
                            </td>
                            <td class="p-4 text-gray-300 max-w-xs">
                                <p class="text-xs line-clamp-3 leading-relaxed font-light">{{ $item->review }}</p>
                                <span class="text-[10px] text-gray-500 mt-1 block">{{ $item->created_at->format('d M Y H:i') }}</span>
                            </td>
                            <td class="p-4 text-center">
                                @if($item->status === 'approved')
                                    <span class="bg-green-500/10 text-green-400 border border-green-500/20 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Disetujui</span>
                                @elseif($item->status === 'rejected')
                                    <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Ditolak</span>
                                @else
                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider">Pending</span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <button wire:click="toggleFeatured({{ $item->id }})" title="Klik untuk ubah status unggulan" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold transition-all {{ $item->is_featured ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-gray-800 text-gray-500 hover:text-gray-300 border border-gray-700' }}">
                                    <i class="fa{{ $item->is_featured ? 's' : 'r' }} fa-star text-amber-400"></i>
                                    <span>{{ $item->is_featured ? 'Unggulan' : 'Standar' }}</span>
                                </button>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if($item->status !== 'approved')
                                        <button wire:click="updateStatus({{ $item->id }}, 'approved')" title="Setujui Ulasan" class="text-green-400 hover:bg-green-500/10 p-2 rounded-lg transition-colors">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif

                                    @if($item->status !== 'rejected')
                                        <button wire:click="updateStatus({{ $item->id }}, 'rejected')" title="Tolak Ulasan" class="text-amber-500 hover:bg-amber-500/10 p-2 rounded-lg transition-colors">
                                            <i class="fas fa-ban"></i>
                                        </button>
                                    @endif

                                    <button wire:click="confirmDelete({{ $item->id }})" title="Hapus Ulasan" class="text-red-400 hover:bg-red-500/10 p-2 rounded-lg transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-gray-500">
                                Tidak ada ulasan yang ditemukan untuk kategori tab ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Admin Form Modal -->
    @if($isFormOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
        <div class="bg-[#1f2937] border border-gray-800 rounded-xl shadow-2xl p-6 max-w-lg w-full">
            <h3 class="text-lg font-bold text-white mb-4">Tambah Testimoni Resmi Klien</h3>
            <form wire:submit.prevent="saveTestimonial" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nama Klien</label>
                    <input type="text" wire:model="client_name" placeholder="Misal: Bapak Hidayat" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-amber-500" required>
                    @error('client_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="flex items-center justify-between mb-1 h-5">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Perusahaan / Instansi</label>
                            <span class="text-[10px] text-gray-500 font-normal lowercase">(opsional)</span>
                        </div>
                        <input type="text" wire:model="client_company" placeholder="Misal: PT Pertamina (Persero)" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                        @error('client_company') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1 h-5">
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Email Klien</label>
                            <span class="text-[10px] text-gray-500 font-normal lowercase">(opsional)</span>
                        </div>
                        <input type="email" wire:model="client_email" placeholder="klien@perusahaan.com" class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-amber-500">
                        @error('client_email') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1 h-5">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Foto Profil / Logo Klien</label>
                        <span class="text-[10px] text-gray-500 font-normal lowercase">(opsional)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="file" wire:model="avatar" accept="image/*" class="w-full text-xs text-gray-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500/10 file:text-amber-400 hover:file:bg-amber-500/20 cursor-pointer">
                        @if($avatar)
                            <img src="{{ $avatar->temporaryUrl() }}" class="w-8 h-8 rounded-full object-cover border border-amber-500/40 shrink-0">
                        @endif
                    </div>
                    @error('avatar') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Rating (Bintang 1 - 5)</label>
                    <select wire:model="rating" class="custom-select cursor-pointer w-full bg-[#111827] border border-gray-700 rounded-lg pl-4 pr-10 py-2.5 text-sm text-white focus:outline-none focus:border-amber-500">
                        <option value="5">5 Bintang (Sangat Memuaskan)</option>
                        <option value="4">4 Bintang (Memuaskan)</option>
                        <option value="3">3 Bintang (Cukup)</option>
                        <option value="2">2 Bintang (Kurang)</option>
                        <option value="1">1 Bintang (Buruk)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Isi Ulasan / Testimoni</label>
                    <textarea wire:model="review" rows="4" placeholder="Tulis testimoni resmi..." class="w-full bg-[#111827] border border-gray-700 rounded-lg px-4 py-2 text-sm text-white focus:outline-none focus:border-amber-500" required></textarea>
                    @error('review') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="is_featured" class="w-4 h-4 text-amber-500 bg-gray-900 border-gray-700 rounded focus:ring-amber-500">
                        <span class="text-xs text-gray-300 font-medium">Tampilkan sebagai Unggulan di Beranda</span>
                    </label>
                </div>
                <div class="flex gap-3 justify-end pt-4 border-t border-gray-800">
                    <button type="button" wire:click="closeForm" class="px-4 py-2 text-xs font-semibold text-gray-400 hover:text-white">Batal</button>
                    <button type="submit" class="px-5 py-2 text-xs font-bold bg-amber-500 hover:bg-amber-600 text-black rounded-lg transition-colors">Simpan Testimoni</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Confirm Delete Modal -->
    @if($isConfirmDeleteOpen)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">
        <div class="bg-[#1f2937] border border-gray-800 rounded-xl shadow-2xl p-6 max-w-sm w-full text-center">
            <div class="w-12 h-12 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h3 class="text-base font-bold text-white mb-2">Hapus Ulasan Ini?</h3>
            <p class="text-gray-400 text-xs mb-6">Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-center">
                <button wire:click="$set('isConfirmDeleteOpen', false)" class="px-4 py-2 text-xs font-semibold text-gray-400 hover:text-white">Batal</button>
                <button wire:click="delete" class="px-4 py-2 text-xs font-bold bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">Ya, Hapus</button>
            </div>
        </div>
    </div>
    @endif
</div>
