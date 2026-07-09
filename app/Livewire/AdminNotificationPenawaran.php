<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuoteRequest;

class AdminNotificationPenawaran extends Component
{
    public int $count = 0;

    public function render()
    {
        $this->count = QuoteRequest::where('status', 'pending')->count();
        return view('livewire.admin-notification-penawaran');
    }
}
