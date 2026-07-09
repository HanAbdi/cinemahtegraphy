<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatRoom;
use App\Models\ChatMessage;

class AdminChatManager extends Component
{
    public $activeRooms = [];
    public ?ChatRoom $selectedRoom = null;
    public $replyMessage = '';
    public $activeTab = 'active'; // 'active' or 'archived'

    public function mount()
    {
        $this->loadRooms();
        $roomId = request()->query('room');
        if ($roomId) {
            $this->selectRoom($roomId);
        }
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->selectedRoom = null;
        $this->loadRooms();
    }


    public function loadRooms()
    {
        $query = ChatRoom::with('messages')
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('sender_type', 'visitor')->where('is_read', false);
            }]);

        if ($this->activeTab === 'archived') {
            $query->where('is_archived', true);
        } else {
            $query->where('is_archived', false);
        }

        $this->activeRooms = $query->orderBy('updated_at', 'desc')->get();
    }

    public function selectRoom($roomId)
    {
        // Mark visitor's unread messages as read
        ChatMessage::where('chat_room_id', $roomId)
            ->where('sender_type', 'visitor')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->selectedRoom = ChatRoom::with('messages')->find($roomId);
    }

    public function sendReply()
    {
        $this->validate([
            'replyMessage' => 'required|string|max:500',
        ]);

        if ($this->selectedRoom && !$this->selectedRoom->is_blocked) {
            $this->selectedRoom->messages()->create([
                'sender_type' => 'admin',
                'message' => strip_tags($this->replyMessage),
            ]);
            
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'replied',
                'model_type' => 'ChatRoom',
                'model_id' => $this->selectedRoom->id,
                'description' => "Membalas pesan dari {$this->selectedRoom->visitor_name}",
            ]);

            $this->replyMessage = '';
            
            // Update the room's updated_at timestamp to bubble it to top
            $this->selectedRoom->touch();
            
            $this->selectRoom($this->selectedRoom->id);
            $this->loadRooms();
        }
    }

    public function closeRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_active' => false]);
            $this->loadRooms();
        }
    }

    public function openRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_active' => true]);
            $this->loadRooms();
        }
    }

    public function blockRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_blocked' => true, 'is_active' => false]);
            $this->loadRooms();
        }
    }

    public function unblockRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_blocked' => false]);
            $this->loadRooms();
        }
    }

    public function archiveRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_archived' => true]);
            $this->loadRooms();
            if ($this->selectedRoom && $this->selectedRoom->id == $roomId) {
                $this->selectedRoom = null;
            }
        }
    }

    public function unarchiveRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_archived' => false]);
            $this->loadRooms();
            if ($this->selectedRoom && $this->selectedRoom->id == $roomId) {
                $this->selectedRoom = null;
            }
        }
    }

    public function deleteRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $name = $room->visitor_name;
            $room->messages()->delete();
            $room->delete();
            
            \App\Models\ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'deleted',
                'model_type' => 'ChatRoom',
                'model_id' => null,
                'description' => "Menghapus obrolan dengan: {$name}",
            ]);

            $this->loadRooms();
            if ($this->selectedRoom && $this->selectedRoom->id == $roomId) {
                $this->selectedRoom = null;
            }
        }
    }
    public function toggleSaveRoom($roomId)
    {
        $room = ChatRoom::find($roomId);
        if ($room) {
            $room->update(['is_saved' => !$room->is_saved]);
            $this->loadRooms();
            if ($this->selectedRoom && $this->selectedRoom->id == $roomId) {
                // Refresh selected room
                $this->selectedRoom = ChatRoom::with(['messages' => function($q) {
                    $q->orderBy('created_at', 'asc');
                }])->find($roomId);
            }
        }
    }
    public function render()
    {
        if ($this->selectedRoom) {
            // refresh selected room's messages
            $this->selectRoom($this->selectedRoom->id);
        }
        $this->loadRooms();

        return view('livewire.admin-chat-manager')->layout('components.admin-layout');
    }
}
