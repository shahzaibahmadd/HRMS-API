<?php

namespace App\DTOs\API;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class ApiDTOs extends BaseDTO
{
    public string $resource;
    public string $url;
    public string $method;
    public array $query_params = [];
    public ?array $request_payload = null;
    public string|array|null $response_payload = null;
    public int $status_code;
    public ?int $user_id = null;

    public function __construct(Request $request, array $params = [])
    {
        $this->resource = $params['resource'];
        $this->url = $params['url'];
        $this->method = $params['method'];
        $this->query_params = $params['query_params'] ?? $request->query();
        $this->request_payload = $params['request_payload'] ?? ($request->isMethod('post') || $request->isMethod('put') ? $request->all() : null);
        $this->response_payload = $params['response_payload'] ?? null;
        $this->status_code = $params['status_code'] ?? 200;
        $this->user_id = $params['user_id'] ?? auth()->id();
    }

}
