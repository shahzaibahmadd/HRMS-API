<?php

namespace App\services\Auth;

use App\DTOs\Auth\LoginDTO;
use App\DTOs\Auth\RegisterDTO;
use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Helpers\ResponseHelper;
use App\Services\ErrorLogging\ErrorLoggingService;
use Throwable;

class AuthService
{
    public function login(LoginDTO $dto): string
    {
        try {
            $credentials = [
                'email' => $dto->email,
                'password' => $dto->password,
            ];

            if (!$token = auth()->attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => ['Invalid credentials.']
                ]);
            }

            return $token;

        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            throw $e;
        }
    }

    public function register(RegisterDTO $dto): string
    {
        try {

//            $user = User::create($dto->toArray());

            $data = $dto->toArray();
            $data['password'] = Hash::make($dto->password);

            $user = User::create($data);
            $user->assignRole($dto->role);

            dispatch(new SendWelcomeEmail($user));

            return auth()->login($user);

        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            throw $e;
        }
    }

    public function me()
    {
        try {
            return auth()->user();
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function logout(): void
    {
        try {
            auth()->logout();
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
        }
    }
}
