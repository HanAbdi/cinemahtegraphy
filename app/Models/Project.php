<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'quote_request_id',
        'title',
        'status',
        'event_date',
        'dp_amount',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function quoteRequest()
    {
        return $this->belongsTo(QuoteRequest::class);
    }
}
