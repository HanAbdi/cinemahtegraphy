<div wire:poll.3s>
    <!-- Floating Chat Button Container -->
    <div class="fixed bottom-6 right-6 z-50">
        <button wire:click="toggleChat" class="relative w-14 h-14 bg-amber-500 rounded-full flex items-center justify-center text-black shadow-xl hover:bg-amber-600 hover:scale-105 transition-all">
            @if($isOpen)
                <i class="fas fa-times text-2xl"></i>
            @else
                <i class="fas fa-comment-dots text-2xl"></i>
                @if(isset($unreadCount) && $unreadCount > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-6 h-6 flex items-center justify-center rounded-full border-2 border-[#0b0f19]">
                        {{ $unreadCount }}
                    </span>
                @endif
            @endif
        </button>
    </div>

    <!-- Chat Window -->
    @if($isOpen)
        <div class="fixed bottom-24 right-6 w-80 sm:w-96 bg-[#111827] border border-gray-800 rounded-2xl shadow-2xl flex flex-col z-50 overflow-hidden" style="height: 500px; max-height: 80vh;">
            
            <!-- Chat Header -->
            <div class="bg-amber-500 p-4 text-black flex justify-between items-center shrink-0">
                <div>
                    <h3 class="font-bold font-heading flex items-center gap-2">Live Chat</h3>
                    <p class="text-[10px] opacity-80">Online</p>
                </div>
            </div>

            <!-- Chat Body -->
            <div class="flex-1 overflow-y-auto p-4 bg-[#0b0f19] flex flex-col space-y-4">
                @if(!$chatRoom)
                    <!-- Start Chat Form -->
                    <div class="flex-1 flex flex-col justify-center items-center text-center space-y-4">
                        <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center text-gray-500 text-2xl">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="w-full">
                            <p class="text-sm text-gray-400 mb-4">Halo! Silakan masukkan nama Anda untuk memulai obrolan.</p>
                            <form wire:submit="startChat" class="flex flex-col gap-2">
                                <!-- Honeypot Field -->
                                <input type="text" wire:model="website_url" class="absolute opacity-0 -z-10" tabindex="-1" autocomplete="off">
                                
                                <input type="text" wire:model="visitorName" placeholder="Nama Anda" class="w-full bg-[#1f2937] border border-gray-700 text-white rounded-lg px-4 py-2 focus:ring-amber-500 focus:border-amber-500 text-sm" required>
                                <button type="submit" class="w-full bg-amber-500 text-black font-semibold rounded-lg px-4 py-2 hover:bg-amber-600 transition-colors flex items-center justify-center gap-2">
                                    <span>Mulai Chat</span>
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Chat Messages -->
                    @if(!$chatRoom->is_saved && !$chatRoom->is_archived)
                        <div class="text-[10px] text-center text-gray-400 bg-gray-500/10 border border-gray-500/20 py-2 px-3 rounded-lg mx-2 mb-2">
                            <i class="fas fa-info-circle"></i> Obrolan ini akan terhapus otomatis jika tidak ada aktivitas selama 24 jam.
                        </div>
                    @else
                        <div class="text-[10px] text-center text-gray-500 my-2">Obrolan dimulai</div>
                    @endif
                    @forelse($messages as $msg)
                        <div class="flex flex-col {{ $msg->sender_type == 'visitor' ? 'items-end' : 'items-start' }}">
                            <div class="max-w-[85%] rounded-xl px-4 py-2 text-sm {{ $msg->sender_type == 'visitor' ? 'bg-amber-500 text-black rounded-br-none' : 'bg-[#1f2937] text-gray-200 border border-gray-800 rounded-bl-none' }} break-words overflow-hidden">
                                {{ $msg->message }}
                            </div>
                            <span class="text-[10px] text-gray-500 mt-1">{{ $msg->created_at->format('H:i') }}</span>
                        </div>
                    @empty
                        <div class="flex-1 flex items-center justify-center text-gray-500 text-sm">
                            Belum ada pesan. Sapa kami sekarang!
                        </div>
                    @endforelse
                    
                    @if($chatRoom->is_blocked)
                        <div class="text-xs text-center text-red-500 my-2 bg-red-500/10 py-2 rounded-lg border border-red-500/20">
                            Akses ditolak. Percakapan ini telah diblokir oleh admin.
                        </div>
                    @elseif(!$chatRoom->is_active)
                        <div class="text-xs text-center text-red-500 my-2 bg-red-500/10 py-2 rounded-lg border border-red-500/20">
                            Obrolan telah ditutup oleh admin. Kirim pesan baru untuk membuka kembali percakapan.
                        </div>
                    @endif
                @endif
            </div>

            <!-- Chat Footer (Input) -->
            @if($chatRoom)
                <div class="p-3 bg-[#111827] border-t border-gray-800 shrink-0">
                    @if($chatRoom->is_blocked)
                        <div class="text-center text-red-500 text-xs py-2 bg-red-500/10 rounded-lg border border-red-500/20">
                            Anda telah diblokir. Anda tidak dapat lagi mengirim pesan.
                        </div>
                    @else
                        <form wire:submit="sendMessage" class="flex flex-col gap-2">
                            <!-- Honeypot Field -->
                            <input type="text" wire:model="website_url" class="absolute opacity-0 -z-10" tabindex="-1" autocomplete="off">

                            <div class="flex items-center gap-2">
                                <input type="text" wire:model="newMessage" placeholder="Ketik pesan..." class="flex-1 bg-[#1f2937] border border-gray-700 text-white rounded-full px-4 py-2 text-sm focus:ring-amber-500 focus:border-amber-500" required>
                                <button type="submit" class="w-10 h-10 bg-amber-500 rounded-full flex justify-center items-center text-black hover:bg-amber-600 transition-colors shrink-0">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            
                            @error('newMessage')
                                <span class="text-red-500 text-xs text-center">{{ $message }}</span>
                            @enderror
                        </form>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    Livewire.on('chat-error', (event) => {
        Swal.fire({
            icon: 'warning',
            title: 'Tunggu Sebentar',
            text: event.message,
            confirmButtonColor: '#f59e0b',
            background: '#1f2937',
            color: '#fff'
        });
    });
});
</script>

