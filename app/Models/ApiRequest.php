<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    protected $fillable = [
        'command',
        'payload',
        'status',
        'response',
        'request_id'
    ];

    protected $casts = [
        'payload' => 'array',
        'response' => 'array'
    ];
}