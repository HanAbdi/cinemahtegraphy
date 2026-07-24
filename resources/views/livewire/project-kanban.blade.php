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
                                
                                @if($project->dp_amount > 0)
                                    <div class="mb-3 inline-block bg-green-500/10 border border-green-500/20 text-green-400 text-[10px] px-2 py-1 rounded-md font-semibold">
                                        <i class="fas fa-money-bill-wave mr-1"></i> DP: Rp {{ number_format($project->dp_amount, 0, ',', '.') }}
                                    </div>
                                @endif

                                <div class="mb-4">
                                    <label class="block mb-1 text-[10px] uppercase font-bold tracking-wider text-gray-500"><i class="far fa-calendar-alt mr-1"></i> Tanggal Event</label>
                                    <input type="date" 
                                           class="w-full bg-[#0b0f19] border border-gray-800 rounded-lg px-3 py-2 text-gray-300 text-xs focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-shadow"
                                           value="{{ $project->event_date ? $project->event_date->format('Y-m-d') : '' }}"
                                           wire:change="setEventDate({{ $project->id }}, $event.target.value)">
                                </div>
                                
                                <div class="flex justify-end space-x-2 border-t border-gray-800/60 pt-3">
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
</div>
