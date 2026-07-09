<div wire:poll.10s class="contents">
    <a href="{{ route('admin.quotes.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('admin.quotes.*') ? 'bg-amber-500 text-black shadow-lg shadow-amber-500/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition-colors' }}">
        <i class="fas fa-file-invoice w-6"></i>
        Penawaran
        @if($count > 0)
            <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-none">
                {{ $count > 99 ? '99+' : $count }}
            </span>
        @endif
    </a>
</div>

