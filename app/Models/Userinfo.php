<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $fillable = [
        'pin',
        'name',
        'department',
        'position',
        'card_number',
        'raw_payload'
    ];

    protected $casts = [
        'raw_payload' => 'array'
    ];
}