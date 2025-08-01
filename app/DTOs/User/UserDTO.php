<?php

namespace App\DTOs\User;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UserDTO extends BaseDTO
{

    public string $name;
    public string $email;
    public ?string $password;
    public ?string $phone;
    public bool $is_active;
    public ?string $profile_image;
    public string $role;

    public ?string $skills;
    public ?string $documents;
    public ?string $resume;
    public ?string $contract;

    public function __construct(
        Request $request,
        ?string $profileImagePath = null,
        ?string $documentsPath = null,
        ?string $resumePath = null,
        ?string $contractPath = null
    ) {
        $this->name          = $request->input('name');
        $this->email         = $request->input('email');
        $this->password      = $request->filled('password') ? $request->input('password') : null;
        $this->phone         = $request->input('phone');
        $this->is_active     = (bool) $request->input('is_active', true);
        $this->role          = $request->input('role');
        $this->profile_image = $profileImagePath;
        $this->skills        = $request->input('skills');
        $this->documents     = $documentsPath;
        $this->resume        = $resumePath;
        $this->contract      = $contractPath;
    }
}
