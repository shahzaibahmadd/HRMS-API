<?php

namespace App\DTOs\User;

use App\DTOs\BaseDTO;
use App\Models\User;
use Illuminate\Http\Request;

class UserDTO extends BaseDTO
{
    public ?string $name;
    public ?string $email;
    public ?string $password;
    public ?string $phone;
    public ?bool $is_active;
    public ?string $profile_image;
    public ?string $role;
    public ?string $skills;
    public ?string $documents;
    public ?string $resume;
    public ?string $contract;

    public function __construct(
        Request $request,
        ?User $existingUser = null,
        ?string $profileImagePath = null,
        ?string $documentsPath = null,
        ?string $resumePath = null,
        ?string $contractPath = null
    ) {
        // Use existingUser values if field is not in request
        $this->name          = $request->has('name')          ? $request->input('name')        : $existingUser?->name;
        $this->email         = $request->has('email')         ? $request->input('email')       : $existingUser?->email;
        $this->password      = $request->has('password')      ? $request->input('password')    : null; // Don't reuse old password
        $this->phone         = $request->has('phone')         ? $request->input('phone')       : $existingUser?->phone;
        $this->is_active     = $request->has('is_active')     ? (bool) $request->input('is_active') : $existingUser?->is_active;
        $this->role          = $request->has('role')          ? $request->input('role')        : $existingUser?->roles->pluck('name')->first();
        $this->profile_image = $profileImagePath              ?? $existingUser?->profile_image;
        $this->skills        = $request->has('skills')        ? $request->input('skills')      : $existingUser?->skills;
        $this->documents     = $documentsPath                 ?? $existingUser?->documents;
        $this->resume        = $resumePath                    ?? $existingUser?->resume;
        $this->contract      = $contractPath                  ?? $existingUser?->contract;
    }
}
