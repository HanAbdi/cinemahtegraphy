<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Greeting -->
            <div class="bg-[#1f2937] overflow-hidden shadow-sm sm:rounded-lg border border-gray-800">
                <div class="p-6 text-gray-100 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-heading text-amber-500 font-bold mb-1">Halo, {{ auth()->user()->name ?? 'Admin' }}! 👋</h3>
                        <p class="text-sm text-gray-400">Berikut adalah ringkasan performa website Cinemahtegraphy Anda saat ini.</p>
                    </div>
                    <div class="text-right hidden sm:block">
                        <p class="text-xs text-gray-500">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Portofolio -->
                <div class="bg-[#1f2937] p-6 rounded-lg border border-gray-800 flex items-center shadow-lg">
                    <div class="p-4 rounded-full bg-gray-800 text-amber-500 mr-4">
                        <i class="fas fa-video text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Total Portofolio</p>
                        <p class="text-2xl font-bold text-white">{{ $totalPortfolios }}</p>
                    </div>
                </div>
                <!-- Leads -->
                <div class="bg-[#1f2937] p-6 rounded-lg border border-gray-800 flex items-center shadow-lg">
                    <div class="p-4 rounded-full bg-gray-800 text-amber-500 mr-4">
                        <i class="fas fa-envelope text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Permintaan Baru</p>
                        <p class="text-2xl font-bold text-white">{{ $newQuotes }}</p>
                    </div>
                </div>
                <!-- Visitors -->
                <div class="bg-[#1f2937] p-6 rounded-lg border border-gray-800 flex items-center shadow-lg">
                    <div class="p-4 rounded-full bg-gray-800 text-amber-500 mr-4">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Pengunjung (Hari Ini)</p>
                        <p class="text-2xl font-bold text-white">{{ $todayVisitors }} <span class="text-xs text-gray-500 font-normal">/ {{ $totalVisitors }} total</span></p>
                    </div>
                </div>
                <!-- Active Chats -->
                <div class="bg-[#1f2937] p-6 rounded-lg border border-gray-800 flex items-center shadow-lg">
                    <div class="p-4 rounded-full bg-gray-800 text-amber-500 mr-4">
                        <i class="fas fa-comments text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Obrolan Aktif</p>
                        <p class="text-2xl font-bold text-white">{{ $activeChats }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Quotes -->
                <div class="lg:col-span-2 bg-[#1f2937] overflow-hidden shadow-sm sm:rounded-lg border border-gray-800">
                    <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                        <h4 class="text-lg font-bold text-white"><i class="fas fa-inbox text-amber-500 mr-2"></i> Permintaan Terbaru</h4>
                        <a href="{{ route('admin.quotes.index') ?? '#' }}" class="text-xs text-amber-500 hover:text-amber-400">Lihat Semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-300">
                            <thead class="bg-[#111827] text-gray-400 uppercase text-xs border-b border-gray-800">
                                <tr>
                                    <th class="px-6 py-3">Nama</th>
                                    <th class="px-6 py-3">Layanan</th>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse($recentQuotes as $quote)
                                    <tr class="hover:bg-[#374151]/50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-white">{{ $quote->name }}</td>
                                        <td class="px-6 py-4">{{ $quote->service_interested }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $quote->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            @if($quote->status == 'new')
                                                <span class="text-amber-500 text-xs uppercase font-semibold">Baru</span>
                                            @elseif($quote->status == 'contacted')
                                                <span class="text-gray-400 text-xs uppercase font-semibold">Dihubungi</span>
                                            @else
                                                <span class="text-gray-600 text-xs uppercase font-semibold">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            <i class="fas fa-box-open text-3xl mb-3 opacity-50 block"></i>
                                            Belum ada permintaan penawaran harga.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Chats -->
                <div class="bg-[#1f2937] overflow-hidden shadow-sm sm:rounded-lg border border-gray-800">
                    <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                        <h4 class="text-lg font-bold text-white"><i class="fas fa-comment-dots text-amber-500 mr-2"></i> Obrolan Terakhir</h4>
                        <a href="{{ route('admin.chat') ?? '#' }}" class="text-xs text-amber-500 hover:text-amber-400">Ke Chat &rarr;</a>
                    </div>
                    <div class="p-4 flex flex-col space-y-4">
                        @forelse($recentChats as $chat)
                            <a href="{{ route('admin.chat', ['room' => $chat->id]) }}" class="block p-3 rounded-lg border border-gray-800 bg-[#111827] hover:border-gray-700 transition-colors group">
                                <div class="flex justify-between items-center mb-1">
                                    <span class="font-bold text-white text-sm group-hover:text-amber-500 transition-colors">{{ $chat->visitor_name }}</span>
                                    <span class="text-[10px] text-gray-500">{{ $chat->updated_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-xs text-gray-400 truncate">
                                    @if($chat->messages->count() > 0)
                                        {{ $chat->messages->first()->sender_type == 'admin' ? 'Anda: ' : '' }}{{ $chat->messages->first()->message }}
                                    @else
                                        <i class="text-gray-600 italic">Belum ada pesan</i>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-6 text-gray-500">
                                <i class="fas fa-comments text-3xl mb-3 opacity-50 block"></i>
                                Belum ada obrolan terbaru.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-[#1f2937] overflow-hidden shadow-sm sm:rounded-lg border border-gray-800">
                <div class="p-6">
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Aksi Cepat</h4>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('admin.portfolios.index') ?? '#' }}" class="bg-[#111827] text-gray-300 hover:text-amber-500 border border-gray-800 hover:border-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="fas fa-plus"></i> Tambah Portofolio
                        </a>
                        <a href="{{ route('admin.chat') ?? '#' }}" class="bg-[#111827] text-gray-300 hover:text-amber-500 border border-gray-800 hover:border-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                            <i class="fas fa-comment"></i> Buka Live Chat
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>
