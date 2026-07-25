<div>
    <h2 class="text-3xl font-heading font-bold text-white mb-8 tracking-tight">Kanban Board Proyek</h2>

    <!-- Sortable CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <div class="flex space-x-6 overflow-x-auto pb-8 snap-x custom-scrollbar">
        @foreach($statuses as $status)
            <div class="min-w-[340px] max-w-[340px] bg-[#111827]/80 backdrop-blur-xl border border-gray-800 rounded-2xl flex flex-col snap-center shadow-[0_8px_30px_rgb(0,0,0,0.4)]">
                <!-- Column Header -->
                <div class="p-5 border-b border-gray-800 bg-gradient-to-b from-[#1f2937]/50 to-transparent rounded-t-2xl flex justify-between items-center">
                    <h3 class="font-bold text-gray-200 tracking-wide">{{ $status }}</h3>
                    <span class="bg-amber-500/10 border border-amber-500/30 text-amber-500 text-xs px-2.5 py-1 rounded-full font-bold shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                        {{ isset($groupedProjects[$status]) ? count($groupedProjects[$status]) : 0 }}
                    </span>
                </div>
                
                <!-- Droppable Area -->
                <div 
                    class="p-4 flex-1 overflow-y-auto space-y-4 min-h-[500px] max-h-[75vh] sortable-list"
                    data-status="{{ $status }}"
                    x-data="{
                        init() {
                            new Sortable(this.$el, {
                                group: 'kanban',
                                animation: 200,
                                ghostClass: 'opacity-50',
                                dragClass: 'scale-105',
                                onEnd: (evt) => {
                                    if (evt.to !== evt.from) {
                                        const projectId = evt.item.dataset.id;
                                        const newStatus = evt.to.dataset.status;
                                        $wire.updateProjectStatus(projectId, newStatus);
                                    }
                                }
                            });
                        }
                    }"
                >
                    @if(isset($groupedProjects[$status]))
                        @foreach($groupedProjects[$status] as $project)
                            <div data-id="{{ $project->id }}" class="bg-[#1f2937]/70 backdrop-blur-sm p-5 rounded-xl border border-gray-700 hover:border-amber-500 transition-all shadow-md group cursor-grab active:cursor-grabbing hover:shadow-[0_4px_20px_rgba(245,158,11,0.15)] relative overflow-hidden">
                                
                                <!-- Decorative top accent -->
                                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-500 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                <h4 class="font-bold text-white text-sm mb-3 leading-snug">{{ $project->title }}</h4>
                                
                                @if($project->total_price > 0 || $project->dp_amount > 0)
                                    <div class="mb-3 flex gap-2">
                                        <div class="inline-block bg-green-500/10 border border-green-500/20 text-green-400 text-[10px] px-2 py-1 rounded-md font-semibold">
                                            <i class="fas fa-money-bill-wave mr-1"></i> DP: Rp {{ number_format($project->dp_amount, 0, ',', '.') }}
                                        </div>
                                        @if($project->payment_status == 'paid')
                                            <div class="inline-block bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] px-2 py-1 rounded-md font-semibold">Lunas</div>
                                        @elseif($project->payment_status == 'partial')
                                            <div class="inline-block bg-amber-500/10 border border-amber-500/20 text-amber-400 text-[10px] px-2 py-1 rounded-md font-semibold">Cicilan</div>
                                        @else
                                            <div class="inline-block bg-red-500/10 border border-red-500/20 text-red-400 text-[10px] px-2 py-1 rounded-md font-semibold">Belum Lunas</div>
                                        @endif
                                    </div>
                                @endif

                                <div class="mb-4">
                                    <label class="block mb-1 text-[10px] uppercase font-bold tracking-wider text-gray-500"><i class="far fa-calendar-alt mr-1"></i> Tanggal Event</label>
                                    <input type="date" 
                                           class="w-full bg-[#0b0f19] border border-gray-800 rounded-lg px-3 py-2 text-gray-300 text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-shadow"
                                           value="{{ $project->event_date ? $project->event_date->format('Y-m-d') : '' }}"
                                           wire:change="setEventDate({{ $project->id }}, $event.target.value)">
                                </div>
                                
                                <div class="flex justify-between items-center border-t border-gray-800/60 pt-3">
                                    <button wire:click.stop="confirmDeleteProject({{ $project->id }})" class="w-8 h-8 rounded-full border border-red-900/30 bg-red-900/10 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" title="Hapus Proyek">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                    <div class="flex justify-end space-x-2">
                                        <button wire:click="viewProjectDetails({{ $project->id }})" class="w-8 h-8 rounded-full bg-gray-500/10 text-gray-400 hover:bg-gray-500 hover:text-white flex items-center justify-center transition-all shadow-[0_0_8px_rgba(107,114,128,0.2)]" title="Detail Proyek">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @php
                                            // Try to extract phone/email from the linked QuoteRequest
                                            $quote = $project->quoteRequest;
                                        @endphp
                                        @if($quote && $quote->phone)
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quote->phone) }}" target="_blank" class="w-8 h-8 rounded-full bg-[#25D366]/10 text-[#25D366] hover:bg-[#25D366] hover:text-white flex items-center justify-center transition-all shadow-[0_0_8px_rgba(37,211,102,0.2)]" title="WhatsApp Klien">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        @endif
                                        @if($quote && $quote->email)
                                            <a href="mailto:{{ $quote->email }}" class="w-8 h-8 rounded-full bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white flex items-center justify-center transition-all shadow-[0_0_8px_rgba(59,130,246,0.2)]" title="Email Klien">
                                                <i class="fas fa-envelope"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Empty placeholder to allow dropping -->
                        <div class="h-full w-full rounded-xl border-2 border-dashed border-gray-800 flex items-center justify-center">
                            <span class="text-xs text-gray-600 font-medium italic">Jatuhkan di sini</span>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            height: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #0b0f19;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #1f2937;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #f59e0b;
        }
    </style>

    <!-- Project Details Modal -->
    @if($showProjectModal && $viewingProject)
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="closeProjectDetails"></div>
        
        <!-- Modal Content -->
        <div class="bg-[#111827] border border-gray-700 rounded-2xl shadow-2xl z-10 w-full max-w-lg overflow-hidden transform transition-all scale-100 opacity-100">
            <div class="p-6 border-b border-gray-800 bg-[#1f2937]/50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-project-diagram text-amber-500 mr-3"></i> Detail Proyek
                </h3>
                <button wire:click="closeProjectDetails" class="text-gray-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Judul Proyek</h4>
                    <p class="text-white font-medium">{{ $viewingProject->title }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Status</h4>
                        <p class="text-amber-500 font-medium">{{ $viewingProject->status }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-1">Tanggal Event</h4>
                        <p class="text-white">{{ $viewingProject->event_date ? $viewingProject->event_date->format('d M Y') : 'Belum ditentukan' }}</p>
                    </div>
                </div>

                <div>
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Keuangan & Pembayaran</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-[#0b0f19] p-4 rounded-xl border border-gray-800">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">Total Harga</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500 text-xs font-bold">Rp</span>
                                <input type="number" wire:model="editTotalPrice" placeholder="0" class="w-full bg-[#111827] border border-gray-700 rounded-lg pl-9 pr-3 py-2 text-gray-200 focus:outline-none focus:border-amber-500 text-xs">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">Terbayar (DP/Cicilan)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500 text-xs font-bold">Rp</span>
                                <input type="number" wire:model="editDpAmount" placeholder="0" class="w-full bg-[#111827] border border-gray-700 rounded-lg pl-9 pr-3 py-2 text-green-400 focus:outline-none focus:border-amber-500 text-xs">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 mb-1">Status Pembayaran</label>
                            <select wire:model="editPaymentStatus" class="custom-select w-full bg-[#111827] border border-gray-700 rounded-lg pl-3 pr-8 py-2 text-gray-200 focus:outline-none focus:border-amber-500 text-xs cursor-pointer">
                                <option value="pending">Belum Lunas (Pending)</option>
                                <option value="partial">Cicilan (Partial)</option>
                                <option value="paid">Lunas (Paid)</option>
                            </select>
                        </div>
                        <div class="md:col-span-3 flex justify-between items-center mt-2 border-t border-gray-800/50 pt-3">
                            <div class="text-sm">
                                <span class="text-gray-400">Sisa Tagihan:</span>
                                @php
                                    $sisa = ($viewingProject->total_price ?: 0) - ($viewingProject->dp_amount ?: 0);
                                @endphp
                                <span class="font-bold {{ $sisa <= 0 ? 'text-emerald-400' : 'text-red-400' }}">Rp {{ number_format($sisa, 0, ',', '.') }}</span>
                            </div>
                            <button wire:click="savePaymentDetails" class="bg-amber-500 hover:bg-amber-600 text-black px-4 py-1.5 rounded-lg text-xs font-bold transition-all shadow-[0_0_10px_rgba(245,158,11,0.2)]">
                                Simpan Pembayaran
                            </button>
                        </div>
                    </div>
                </div>

                @if($viewingProject->quoteRequest)
                <div class="pt-4 border-t border-gray-800">
                    <h4 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-2">Pesan Tambahan (Penawaran)</h4>
                    <div class="bg-[#0b0f19] p-4 rounded-lg border border-gray-800 text-gray-300 whitespace-pre-wrap leading-relaxed">
                        {{ $viewingProject->quoteRequest->message ?: 'Tidak ada pesan tambahan.' }}
                    </div>
                </div>
                @endif
            </div>
            
            <div class="p-6 border-t border-gray-800 flex justify-between bg-[#1f2937]/30">
                <a href="{{ route('admin.projects.invoice', $viewingProject->id) }}" target="_blank" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-blue-400 border border-blue-400/30 hover:bg-blue-400 hover:text-black transition-colors flex items-center">
                    <i class="fas fa-file-invoice mr-2"></i> Print Invoice
                </a>
                <button wire:click="closeProjectDetails" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white bg-gray-800 hover:bg-gray-700 transition-colors">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($confirmingProjectDeletion)
    <div class="fixed inset-0 z-[60] flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" wire:click="cancelDeleteProject"></div>
        
        <!-- Modal Content -->
        <div class="bg-[#111827] border border-gray-700 rounded-2xl shadow-2xl z-10 w-full max-w-sm overflow-hidden transform transition-all scale-100 opacity-100 p-6 text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-900/30 mb-4">
                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-2">Hapus Proyek?</h3>
            <p class="text-sm text-gray-400 mb-6">Apakah Anda yakin ingin menghapus proyek ini beserta seluruh riwayat pembayarannya? Tindakan ini tidak dapat dibatalkan.</p>
            
            <div class="flex gap-3 justify-center">
                <button wire:click="cancelDeleteProject" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-gray-400 border border-gray-700 hover:bg-gray-800 hover:text-white transition-colors w-full">
                    Batal
                </button>
                <button wire:click="deleteProject" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-[0_0_15px_rgba(220,38,38,0.3)] transition-all w-full">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
