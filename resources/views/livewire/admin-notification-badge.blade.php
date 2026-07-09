<div wire:poll.10s class="contents">
    @if($unreadChats > 0)
        <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center leading-none">
            {{ $unreadChats > 99 ? '99+' : $unreadChats }}
        </span>
    @endif
</div>
