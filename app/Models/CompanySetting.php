<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'office_address',
        'email',
        'phone',
        'maps_iframe_url',
        'instagram_url',
        'youtube_url',
    ];

    public static function getSettings()
    {
        return static::firstOrCreate([], [
            'office_address' => 'Jl. Cakra Sentosa Block z No.3 - Wisma Cakra. Kel. Limo - Kec Limo - Cinere Depok',
            'email' => 'info@cinemahtegraphy.com',
            'phone' => '(+62) 123-456-789',
            'maps_iframe_url' => 'https://maps.google.com/maps?q=Jl.%20Cakra%20Sentosa%20Block%20z%20No.3%20-%20Wisma%20Cakra.%20Kel.%20Limo%20-%20Kec%20Limo%20-%20Cinere%20Depok&t=&z=16&ie=UTF8&iwloc=&output=embed',
            'instagram_url' => 'https://instagram.com/cinemahtegraphy',
            'youtube_url' => 'https://youtube.com/cinemahtegraphy',
        ]);
    }
}
