<div wire:poll.2s>
    <h2 class="text-2xl font-heading font-bold text-gray-100 mb-6">Live Chat Pengunjung</h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- List Panel -->
        <div class="lg:col-span-1 bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden flex flex-col h-[700px]">
            <div class="flex border-b border-gray-800 bg-[#111827]">
                <button wire:click="setTab('active')" class="flex-1 py-4 text-sm font-semibold transition-colors {{ $activeTab === 'active' ? 'text-amber-500 border-b-2 border-amber-500 bg-gray-800/30' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                    Inbox
                </button>
                <button wire:click="setTab('archived')" class="flex-1 py-4 text-sm font-semibold transition-colors {{ $activeTab === 'archived' ? 'text-amber-500 border-b-2 border-amber-500 bg-gray-800/30' : 'text-gray-400 hover:text-white hover:bg-gray-800/50' }}">
                    Arsip
                </button>
            </div>
            
            <div class="overflow-y-auto flex-1 divide-y divide-gray-800">
                @forelse($activeRooms as $room)
                    <button wire:click="selectRoom({{ $room->id }})" class="w-full text-left p-4 hover:bg-gray-800/50 transition-colors {{ $selectedRoom && $selectedRoom->id == $room->id ? 'bg-gray-800/80 border-l-4 border-amber-500' : 'border-l-4 border-transparent' }}">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-medium text-white truncate flex items-center flex-wrap gap-1">
                                {{ $room->visitor_name }}
                                @if($room->unread_count > 0)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-1">{{ $room->unread_count }}</span>
                                @endif
                                @if($room->is_blocked)
                                    <span class="bg-red-900/50 text-red-400 border border-red-500/30 text-[9px] px-1.5 py-0.5 rounded ml-1">Blokir</span>
                                @elseif(!$room->is_active)
                                    <span class="bg-gray-700 text-gray-300 text-[9px] px-1.5 py-0.5 rounded ml-1">Tutup</span>
                                @endif
                                @if($room->is_saved)
                                    <span class="bg-amber-500/20 text-amber-500 border border-amber-500/30 text-[9px] px-1.5 py-0.5 rounded ml-1" title="Disimpan"><i class="fas fa-bookmark"></i> Tersimpan</span>
                                @endif
                            </h4>
                            <span class="text-xs text-gray-500 whitespace-nowrap">{{ $room->updated_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-xs truncate {{ $room->unread_count > 0 ? 'text-gray-200 font-bold' : 'text-gray-400' }}">
                            @if($room->messages->count() > 0)
                                {{ $room->messages->last()->message }}
                            @else
                                <i>Belum ada pesan</i>
                            @endif
                        </p>
                    </button>
                @empty
                    <div class="p-8 text-center text-gray-500 text-sm">
                        {{ $activeTab === 'active' ? 'Tidak ada obrolan aktif.' : 'Tidak ada obrolan di arsip.' }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Detail Panel -->
        <div class="lg:col-span-2 bg-[#1f2937] border border-gray-800 rounded-lg overflow-hidden h-[700px] flex flex-col">
            @if($selectedRoom)
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-800 bg-[#111827] flex flex-col md:flex-row md:justify-between items-start md:items-center gap-4">
                    <div>
                        <h3 class="text-xl font-bold text-white">{{ $selectedRoom->visitor_name }}</h3>
                        @if($selectedRoom->is_blocked)
                            <p class="text-xs text-red-400 flex items-center mt-1">
                                <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Diblokir
                            </p>
                        @elseif(!$selectedRoom->is_active)
                            <p class="text-xs text-gray-400 flex items-center mt-1">
                                <span class="w-2 h-2 rounded-full bg-gray-500 mr-2"></span> Ditutup
                            </p>
                        @else
                            <p class="text-xs text-white flex items-center mt-1">
                                <span class="w-2 h-2 rounded-full bg-white mr-2"></span> Sedang Aktif
                            </p>
                        @endif
                    </div>
                    
                    <div class="flex gap-2 flex-wrap justify-end">
                        @if(!$selectedRoom->is_blocked)
                            <button wire:click="blockRoom({{ $selectedRoom->id }})" wire:confirm="Yakin ingin memblokir pengunjung ini?" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-red-500/20" title="Blokir Pengunjung">
                                <i class="fas fa-ban"></i> Blokir
                            </button>
                        @else
                            <button wire:click="unblockRoom({{ $selectedRoom->id }})" class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-red-500/20" title="Buka Blokir">
                                <i class="fas fa-unlock"></i> Buka Blokir
                            </button>
                        @endif

                        @if($selectedRoom->is_active)
                            <button wire:click="closeRoom({{ $selectedRoom->id }})" class="bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-amber-500/20" title="Tutup Obrolan">
                                <i class="fas fa-times-circle"></i> Tutup
                            </button>
                        @else
                            <button wire:click="openRoom({{ $selectedRoom->id }})" class="bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-amber-500/20" title="Buka Kembali Obrolan">
                                <i class="fas fa-folder-open"></i> Buka Obrolan
                            </button>
                        @endif

                        @if(!$selectedRoom->is_archived)
                            <button wire:click="archiveRoom({{ $selectedRoom->id }})" class="bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-amber-500/20" title="Arsipkan">
                                <i class="fas fa-archive"></i> Arsipkan
                            </button>
                        @else
                            <button wire:click="unarchiveRoom({{ $selectedRoom->id }})" class="bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-amber-500/20" title="Keluarkan dari Arsip">
                                <i class="fas fa-box-open"></i> Batal Arsip
                            </button>
                        @endif

                        @if(!$selectedRoom->is_saved)
                            <button wire:click="toggleSaveRoom({{ $selectedRoom->id }})" class="bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-amber-500/20" title="Simpan agar tidak terhapus otomatis">
                                <i class="far fa-bookmark"></i> Simpan
                            </button>
                        @else
                            <button wire:click="toggleSaveRoom({{ $selectedRoom->id }})" class="bg-amber-500 text-black hover:bg-amber-600 px-3 py-1.5 rounded text-xs font-semibold transition-colors border border-amber-500" title="Batal simpan">
                                <i class="fas fa-bookmark"></i> Tersimpan
                            </button>
                        @endif

                        <button wire:click="deleteRoom({{ $selectedRoom->id }})" wire:confirm="PERINGATAN: Hapus obrolan ini secara permanen? Data tidak dapat dikembalikan." class="bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded text-xs transition-colors border border-red-500/20" title="Hapus Permanen">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </button>
                    </div>
                </div>
                
                <!-- Chat Body -->
                <div class="p-6 flex-1 overflow-y-auto bg-[#0b0f19] flex flex-col space-y-4">
                    @if(!$selectedRoom->is_saved && !$selectedRoom->is_archived)
                        <div class="bg-gray-500/10 border border-gray-500/20 text-gray-400 text-xs text-center py-2 px-4 rounded-lg flex items-center justify-center gap-2">
                            <i class="fas fa-info-circle"></i> Obrolan ini akan terhapus otomatis jika tidak ada pesan baru dalam 24 jam terakhir.
                        </div>
                    @endif
                    @forelse($selectedRoom->messages as $msg)
                        <div class="flex flex-col {{ $msg->sender_type == 'admin' ? 'items-end' : 'items-start' }}">
                            <div class="max-w-[75%] rounded-xl px-4 py-3 text-sm {{ $msg->sender_type == 'admin' ? 'bg-amber-500 text-black rounded-br-none' : 'bg-[#1f2937] text-gray-200 border border-gray-800 rounded-bl-none' }}">
                                {{ $msg->message }}
                            </div>
                            <span class="text-[10px] text-gray-500 mt-1">{{ $msg->sender_type == 'admin' ? 'Admin' : $selectedRoom->visitor_name }} • {{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    @empty
                        <div class="flex-1 flex items-center justify-center text-gray-500 text-sm">
                            Belum ada pesan.
                        </div>
                    @endforelse
                </div>

                <!-- Chat Footer (Input) -->
                <div class="p-4 bg-[#111827] border-t border-gray-800">
                    @if($selectedRoom->is_blocked)
                        <div class="text-center text-red-500 text-sm py-3 bg-red-500/10 rounded-lg border border-red-500/20">
                            <i class="fas fa-ban mr-1"></i> Pengunjung ini telah diblokir. Tidak dapat membalas pesan.
                        </div>
                    @else
                        <form wire:submit="sendReply" class="flex items-center gap-3">
                            <input type="text" wire:model="replyMessage" placeholder="Ketik balasan Anda..." class="flex-1 bg-[#1f2937] border border-gray-700 text-white rounded-lg px-4 py-3 text-sm focus:ring-amber-500 focus:border-amber-500" required>
                            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-black px-6 py-3 rounded-lg font-semibold transition-colors flex items-center justify-center gap-2">
                                Kirim <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    @endif
                </div>
            @else
                <!-- Empty State -->
                <div class="flex-1 flex flex-col items-center justify-center text-gray-500 p-8">
                    <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center text-4xl mb-6">
                        <i class="fas fa-comments text-gray-600"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2 font-heading">Pilih Obrolan</h3>
                    <p class="text-center max-w-sm">Pilih obrolan dari daftar di sebelah kiri untuk melihat pesan dan merespons pengunjung.</p>
                </div>
            @endif
        </div>
    </div>
</div>

