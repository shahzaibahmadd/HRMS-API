<?php

namespace App\Services\ErrorLogging;

use App\Models\error_logs;
use Throwable;

class ErrorLoggingService
{

    public static function log(Throwable $e){

        error_logs::create([
            'message'=>$e->getMessage(),
            'file'=>$e->getFile(),
            'line'=>$e->getLine(),
            'trace' => $e->getTraceAsString(),
            'user_id'=>auth()->check()?auth()->id():null,
        ]);
    }

}
