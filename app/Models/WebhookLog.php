<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $fillable = [
        'event_type',
        'payload',
        'status',
        'processed_data'
    ];

    protected $casts = [
        'payload' => 'array',
        'processed_data' => 'array'
    ];
}