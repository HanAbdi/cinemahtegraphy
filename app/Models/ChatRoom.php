<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = [
        'session_token',
        'visitor_name',
        'is_active',
        'is_blocked',
        'is_archived',
        'is_saved',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
