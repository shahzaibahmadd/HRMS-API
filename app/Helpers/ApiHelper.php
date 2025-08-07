<?php

namespace App\Helpers;

use App\DTOs\API\ApiDTOs;
use App\Models\ApiLog;
use App\Services\ErrorLogging\ErrorLoggingService;


class ApiHelper
{

    public static function logApi(ApiDTOs $dto): void
    {
        try {
            ApiLog::create($dto->toArray());
        } catch (\Throwable $e) {
            ErrorLoggingService::log($e);
        }
    }

}
