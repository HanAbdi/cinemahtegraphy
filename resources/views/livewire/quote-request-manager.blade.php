<div>
    <h2 class="text-2xl font-heading font-bold text-gray-100 mb-6">Permintaan Penawaran (Quotes)</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- List Panel -->
        <div class="lg:col-span-1 bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden flex flex-col h-[700px]">
            <div class="p-4 border-b border-gray-800 bg-[#111827]">
                <h3 class="font-semibold text-gray-300">Kotak Masuk</h3>
            </div>
            
            <div class="overflow-y-auto flex-1 divide-y divide-gray-800">
                @forelse($quotes as $q)
                    <div class="w-full text-left relative hover:bg-gray-800/50 transition-colors {{ $viewingQuote && $viewingQuote->id == $q->id ? 'bg-gray-800/80 border-l-4 border-amber-500' : 'border-l-4 border-transparent' }}">
                        <div class="p-4 cursor-pointer" wire:click="viewDetails({{ $q->id }})">
                            <div class="flex justify-between items-start mb-1">
                                <h4 class="font-medium {{ $q->read_at ? 'text-gray-300' : 'text-white font-bold' }} truncate pr-8">{{ $q->name }}</h4>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $q->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-amber-500 mb-2 truncate pr-8">{{ $q->service_interested }}</p>
                            
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-xs uppercase font-semibold
                                    {{ $q->status == 'new' ? 'text-amber-500' : 
                                      ($q->status == 'processing' ? 'text-blue-400' : 
                                      ($q->status == 'approved' ? 'text-green-500' : 'text-gray-600')) }}">
                                    {{ ucfirst($q->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="absolute bottom-4 right-4 flex items-center gap-2">
                            @if($q->is_archived)
                                <i class="fas fa-archive text-gray-600 text-xs"></i>
                            @endif
                            <button wire:click.stop="confirmDeleteQuote({{ $q->id }})" class="text-gray-500 hover:text-red-500 transition-colors" title="Hapus">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">
                        Belum ada permintaan masuk.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Detail Panel -->
        <div class="lg:col-span-2 bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden h-[700px] flex flex-col">
            @if($viewingQuote)
                <div class="p-6 border-b border-gray-800 bg-[#111827] flex flex-col xl:flex-row xl:items-center justify-between gap-4">
                    <div class="min-w-0 flex-1">
                        <h3 class="text-xl font-bold text-white mb-1 truncate">{{ $viewingQuote->name }}</h3>
                        <div class="text-sm text-gray-400 flex flex-wrap items-center gap-x-4 gap-y-1">
                            <span class="inline-flex items-center"><i class="fas fa-envelope mr-1.5 text-xs text-gray-500"></i> {{ $viewingQuote->email }}</span>
                            @if($viewingQuote->phone)
                                <span class="inline-flex items-center"><i class="fas fa-phone mr-1.5 text-xs text-gray-500"></i> {{ $viewingQuote->phone }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-2.5 shrink-0">
                        <div class="relative">
                            <select wire:change="updateStatus({{ $viewingQuote->id }}, $event.target.value)" class="custom-select h-10 bg-[#0b0f19] border border-gray-700 hover:border-gray-600 text-gray-200 text-xs font-semibold rounded-lg pl-3.5 pr-9 focus:ring-1 focus:ring-amber-500 focus:border-amber-500 cursor-pointer outline-none transition-colors">
                                <option value="new" {{ $viewingQuote->status == 'new' ? 'selected' : '' }}>Status: New</option>
                                <option value="processing" {{ $viewingQuote->status == 'processing' ? 'selected' : '' }}>Status: Processing</option>
                                <option value="approved" {{ $viewingQuote->status == 'approved' ? 'selected' : '' }}>Status: Approved</option>
                                <option value="finished" {{ $viewingQuote->status == 'finished' ? 'selected' : '' }}>Status: Finished</option>
                            </select>
                        </div>
                        
                        @if($viewingQuote->status === 'approved')
                            <button wire:click="confirmConvert({{ $viewingQuote->id }})" class="h-10 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-black px-4 rounded-lg text-xs font-extrabold uppercase tracking-wide transition-all shadow-lg shadow-amber-500/20 active:scale-95 flex items-center shrink-0 cursor-pointer">
                                <i class="fas fa-magic mr-2 text-xs"></i> Convert to Project
                            </button>
                        @endif
                        
                        <div class="flex items-center gap-1.5 border-l border-gray-800 pl-2.5">
                            <button wire:click="toggleArchive({{ $viewingQuote->id }})" class="w-10 h-10 flex items-center justify-center border border-gray-800 bg-[#0b0f19] rounded-lg hover:bg-gray-800 hover:border-gray-700 transition-colors {{ $viewingQuote->is_archived ? 'text-amber-500' : 'text-gray-400' }}" title="Arsipkan">
                                <i class="fas fa-archive text-sm"></i>
                            </button>
                            
                            <button wire:click="confirmDeleteQuote({{ $viewingQuote->id }})" class="w-10 h-10 flex items-center justify-center border border-red-900/40 bg-red-950/20 text-red-400 rounded-lg hover:bg-red-600 hover:text-white transition-colors" title="Hapus">
                                <i class="fas fa-trash-alt text-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 flex-1 overflow-y-auto">
                    <!-- Contact Actions -->
                    <div class="flex gap-4 mb-8">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $viewingQuote->phone) }}" target="_blank" class="flex-1 bg-green-500/10 border border-green-500/30 text-green-500 hover:bg-green-500 hover:text-black py-3 rounded-xl flex items-center justify-center font-semibold transition-all shadow-[0_0_10px_rgba(34,197,94,0.1)] hover:shadow-[0_0_20px_rgba(34,197,94,0.4)] transform hover:-translate-y-1">
                            <i class="fab fa-whatsapp text-lg mr-2"></i> Hubungi via WhatsApp
                        </a>
                        <a href="mailto:{{ $viewingQuote->email }}" class="flex-1 bg-blue-500/10 border border-blue-500/30 text-blue-400 hover:bg-blue-500 hover:text-white py-3 rounded-xl flex items-center justify-center font-semibold transition-all shadow-[0_0_10px_rgba(59,130,246,0.1)] hover:shadow-[0_0_20px_rgba(59,130,246,0.4)] transform hover:-translate-y-1">
                            <i class="fas fa-envelope text-lg mr-2"></i> Kirim Email
                        </a>
                    </div>

                    <div class="mb-6">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Layanan yang Diminati</div>
                        <div class="inline-block px-3 py-1 bg-amber-500/10 text-amber-500 rounded-full text-sm font-medium">
                            {{ $viewingQuote->service_interested }}
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pesan Tambahan</div>
                        <div class="bg-[#0b0f19] p-4 rounded-lg border border-gray-800 text-gray-300 whitespace-pre-wrap leading-relaxed">
                            {{ $viewingQuote->message ?: 'Tidak ada pesan tambahan.' }}
                        </div>
                    </div>
                    
                    <div class="mt-8 text-xs text-gray-500">
                        Dikirim pada: {{ $viewingQuote->created_at->format('d M Y, H:i') }}
                    </div>
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center text-gray-500">
                    <i class="fas fa-envelope-open-text text-5xl mb-4 text-gray-700"></i>
                    <p>Pilih pesan di sebelah kiri untuk membaca detailnya.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Premium Convert Modal -->
    @if($showConvertModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="cancelConvert"></div>
        
        <!-- Modal Content -->
        <div class="bg-[#111827] border border-gray-700 rounded-2xl shadow-2xl z-10 w-full max-w-md overflow-hidden transform transition-all scale-100 opacity-100">
            <div class="p-6 border-b border-gray-800 bg-[#1f2937]/50">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-rocket text-amber-500 mr-3"></i> Konversi ke Proyek
                </h3>
                <p class="text-xs text-gray-400 mt-1">Lengkapi data awal untuk memindahkan klien ke Kanban Board.</p>
            </div>
            
            <div class="p-6 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Event (Opsional)</label>
                    <input type="date" wire:model="convertEventDate" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg px-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-shadow">
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Total Harga (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" wire:model="convertTotalPrice" placeholder="0" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg pl-10 pr-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-shadow">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">Uang Muka / DP (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-2.5 text-gray-500 font-semibold">Rp</span>
                            <input type="number" wire:model="convertDpAmount" placeholder="0" class="w-full bg-[#0b0f19] border border-gray-700 rounded-lg pl-10 pr-4 py-2.5 text-gray-200 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-shadow">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t border-gray-800 flex justify-end gap-3 bg-[#1f2937]/30">
                <button wire:click="cancelConvert" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-400 hover:text-white hover:bg-gray-800 transition-colors">
                    Batal
                </button>
                <button wire:click="convertToProject" class="px-5 py-2.5 rounded-lg text-sm font-bold text-black bg-amber-500 hover:bg-amber-600 shadow-[0_0_15px_rgba(245,158,11,0.3)] transition-all">
                    Buat Proyek Baru
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingQuoteDeletion)
    <div class="fixed inset-0 z-[60] flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="cancelDeleteQuote"></div>
        
        <!-- Modal Content -->
        <div class="bg-[#111827] border border-gray-700 rounded-2xl shadow-2xl z-10 w-full max-w-sm overflow-hidden transform transition-all scale-100 opacity-100 p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-900/30 mb-4">
                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Hapus Penawaran?</h3>
            <p class="text-sm text-gray-400 mb-6">Apakah Anda yakin ingin menghapus penawaran ini? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex gap-3 justify-center">
                <button wire:click="cancelDeleteQuote" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-400 border border-gray-700 hover:bg-gray-800 hover:text-white transition-colors w-full">
                    Batal
                </button>
                <button wire:click="deleteQuote" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-[0_0_15px_rgba(220,38,38,0.3)] transition-all w-full">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
