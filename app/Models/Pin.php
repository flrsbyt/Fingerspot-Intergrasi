<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pin extends Model
{
    protected $fillable = [
        'pin',
        'device_name',
        'device_sn',
        'is_active',
        'raw_payload'
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'is_active' => 'boolean'
    ];
}