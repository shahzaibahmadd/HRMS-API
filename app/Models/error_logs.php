<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class error_logs extends Model
{
    use HasFactory;

    protected $fillable = [
        'message', 'file', 'line', 'trace',
    ];


}
