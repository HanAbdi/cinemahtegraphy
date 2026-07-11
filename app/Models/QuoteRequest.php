<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'service_interested', 'message', 
        'status', 'is_archived', 'read_at'
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function project()
    {
        return $this->hasOne(Project::class);
    }
}
