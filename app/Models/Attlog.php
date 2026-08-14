<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attlog extends Model
{
    protected $fillable = [
        'pin',
        'scan_time',
        'status',
        'verify',
        'photo_url',
        'raw_payload'
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'scan_time' => 'datetime',
        'verify' => 'integer'
    ];
}