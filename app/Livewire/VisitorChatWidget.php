<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class VisitorChatWidget extends Component
{
    public $isOpen = false;
    public $visitorName = '';
    public $newMessage = '';
    public $website_url = ''; // Honeypot field
    
    // E2EE fields removed

    #[\Livewire\Attributes\Computed]
    public function chatRoom()
    {
        $sessionToken = Session::get('chat_session_token');
        if ($sessionToken) {
            $room = ChatRoom::where('session_token', $sessionToken)->first();
            if (!$room) {
                Session::forget('chat_session_token');
            }
            return $room;
        }
        return null;
    }

    public function mount()
    {
        if ($this->chatRoom()) {
            $this->visitorName = $this->chatRoom()->visitor_name;
        }
    }

    public function startChat()
    {
        // Honeypot check
        if (!empty($this->website_url)) {
            return; // Silently ignore if bot filled honeypot
        }

        $this->validate([
            'visitorName' => 'required|string|max:50',
        ]);

        $sessionToken = (string) Str::uuid();
        Session::put('chat_session_token', $sessionToken);

        ChatRoom::create([
            'session_token' => $sessionToken,
            'visitor_name' => $this->visitorName,
            'is_active' => true,
        ]);
        
        // Unset any previous instance from computed cache
        unset($this->chatRoom);
    }

    public function sendMessage()
    {
        // Honeypot check
        if (!empty($this->website_url)) {
            return; // Silently ignore bot
        }

        // Rate Limiter: max 5 message per 60 detik per session token/IP
        $sessionToken = Session::get('chat_session_token') ?? request()->ip();

        $executed = RateLimiter::attempt(
            'send-message:'.$sessionToken,
            5,
            function() {
                $this->validate([
                    'newMessage' => 'required|string|max:500',
                ]);

                $room = $this->chatRoom();
                if ($room) {
                    if ($room->is_blocked) {
                        return; // Cannot send message if blocked
                    }

                    // Re-activate room if it was closed by admin
                    if (!$room->is_active) {
                        $room->update(['is_active' => true]);
                    }
                    
                    $room->messages()->create([
                        'sender_type' => 'visitor',
                        'message' => strip_tags($this->newMessage),
                    ]);
                    $this->newMessage = '';
                }
            },
            60
        );

        if (! $executed) {
            $seconds = RateLimiter::availableIn('send-message:'.$sessionToken);
            $this->dispatch('chat-error', message: 'Mohon tunggu ' . $seconds . ' detik sebelum mengirim pesan berikutnya.');
            return;
        }
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function render()
    {
        $messages = [];
        $unreadCount = 0;
        
        $room = $this->chatRoom();
        if ($room) {
            $messages = $room->messages()->orderBy('created_at', 'asc')->get();
            
            if ($this->isOpen) {
                // If chat is open, mark all admin messages as read
                $room->messages()
                    ->where('sender_type', 'admin')
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            } else {
                // If chat is closed, count unread admin messages
                $unreadCount = $room->messages()
                    ->where('sender_type', 'admin')
                    ->where('is_read', false)
                    ->count();
            }
        }
        
        return view('livewire.visitor-chat-widget', [
            'messages' => $messages,
            'unreadCount' => $unreadCount,
            'chatRoom' => $room,
        ]);
    }
}
