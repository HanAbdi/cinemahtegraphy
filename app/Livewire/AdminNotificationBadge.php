<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\QuoteRequest;

class AdminNotificationBadge extends Component
{
    public int $unreadChats = 0;
    public int $newQuotes = 0;

    public function mount()
    {
        $this->loadCounts();
    }

    public function loadCounts()
    {
        $this->unreadChats = ChatRoom::where('is_archived', false)
            ->where('is_blocked', false)
            ->whereHas('messages', function ($q) {
                $q->where('sender_type', 'visitor')->where('is_read', false);
            })->count();

        $this->newQuotes = QuoteRequest::where('status', 'pending')->count();
    }

    public function render()
    {
        $this->loadCounts();
        return view('livewire.admin-notification-badge');
    }
}
