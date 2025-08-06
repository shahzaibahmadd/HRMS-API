<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    use HasFactory;
    protected $fillable = [
        'resource',
        'url',
        'method',
        'query_params',
        'request_payload',
        'response_payload',
        'status_code',
        'user_id',
    ];

    protected $casts = [
        'query_params' => 'array',
        'request_payload' => 'array',
        'response_payload' => 'array',
    ];
}
