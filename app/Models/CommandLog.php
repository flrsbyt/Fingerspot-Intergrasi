<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommandLog extends Model
{
    protected $fillable = [
        'command',
        'parameters',
        'status',
        'message'
    ];

    protected $casts = [
        'parameters' => 'array'
    ];
}