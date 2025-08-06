<?php

namespace App\Http\Middleware;

use App\DTOs\API\ApiDTOs;
use App\Helpers\ApiHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Handle the request and capture the response
        $response = $next($request);

        try {
            // Only log API routes (usually start with `/api`)
            if ($request->is('api/*')) {
                $dto = new ApiDTOs($request, [
                    'resource' => $request->route()?->getName() ?? 'hrms',
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'status_code' => $response->status(),
                    'response_payload' => $this->getResponseContent($response),
                ]);

                ApiHelper::logApi($dto);
            }
        } catch (\Throwable $e) {
            // Log failure silently, do not crash the response
            \App\Services\ErrorLogging\ErrorLoggingService::log($e);
        }

        return $response;
    }

    private function getResponseContent(Response $response)
    {
        $original = $response->getOriginalContent();

        if (is_array($original) || is_object($original)) {
            return $original;
        }

        // Attempt to decode JSON if string
        $json = json_decode($response->getContent(), true);
        return is_array($json) ? $json : $response->getContent();
    }
}
