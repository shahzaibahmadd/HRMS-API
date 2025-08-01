<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Services\Auth\AuthService;
use App\services\ErrorLogging\ErrorLoggingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request)
    {
        $dto = new RegisterDTO(...$request->validated());
        $token = $this->authService->register($dto);

        return ResponseHelper::success(['token' => $token], 'Registration successful');
    }

    public function login(Request $request)
    {
        try {
//            dd(decrypt($request->key));

//            Cache::put('token', $token, 60);
            $dto = new LoginDTO($request->email, $request->password);
            $token = $this->authService->login($dto);

            return ResponseHelper::success(['token' => $token], 'Login successful');
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return ResponseHelper::error('Login failed. Please check your credentials.');
        }
    }

    public function me()
    {
        return ResponseHelper::success($this->authService->me(), 'User details');
    }

    public function logout()
    {
        $this->authService->logout();
        return ResponseHelper::success(null, 'Logged out');
    }
}
