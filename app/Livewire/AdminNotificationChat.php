<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;

class AdminNotificationChat extends Component
{
    public int $count = 0;

    public function render()
    {
        $this->count = ChatRoom::where('is_archived', false)
            ->where('is_blocked', false)
            ->whereHas('messages', fn($q) => $q->where('sender_type', 'visitor')->where('is_read', false))
            ->count();
        return view('livewire.admin-notification-chat');
    }
}
