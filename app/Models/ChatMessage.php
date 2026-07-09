<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_room_id',
        'sender_type', // 'visitor' or 'admin'
        'message',
        'is_read',
    ];

    protected $casts = [
        'message' => 'encrypted',
    ];

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class);
    }
}
