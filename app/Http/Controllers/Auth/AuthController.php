<?php

namespace App\Http\Controllers\Auth;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\DTOs\User\UserDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\Auth\AuthResource;
use App\services\Auth\AuthService;
use App\services\ErrorLogging\ErrorLoggingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Throwable;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService) {}

    public function register(RegisterRequest $request)
    {
        try {
            $dto = new RegisterDTO(...$request->validated());
            $token = $this->authService->register($dto);
            $user = auth()->user();

            return ResponseHelper::success(['token' => $token,
                'user'  => new AuthResource($user),], 'Registration successful');

        }catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return ResponseHelper::error('Register failed. Please check your credentials.');

        }
        }

    public function login(Request $request)
    {
        try {
//            dd(decrypt($request->key));

//            Cache::put('token', $token, 60);
            $dto = new LoginDTO($request->email, $request->password);
            $token = $this->authService->login($dto);
            $user = auth()->user();

            return ResponseHelper::success([
                'token' => $token,
                'user'  => new AuthResource($user),
            ], 'Login successful');
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
        if(auth()->check()){
            $this->authService->logout();
            return ResponseHelper::success(null, 'Logged out');
        }
        else {
            return ResponseHelper::error(null, 'Already logged out');
        }
    }
}
