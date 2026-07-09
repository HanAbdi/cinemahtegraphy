<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    protected $fillable = [
        'title', 'category', 'client', 'year', 'video_url', 
        'description', 'service_type', 'image_path', 'tags', 'project_scope', 'tag_scheme'
    ];
    
    protected $casts = [
        'tags' => 'array',
    ];
}
