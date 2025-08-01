<?php

namespace App\DTOs\Auth;

use App\DTOs\BaseDTO;

class RegisterDTO extends BaseDTO
{

    public string $name;
    public string $email;
    public string $password;
    public string $phone;
    public string $role;

    public function __construct(string $name, string $email, string $password, string $phone, string $role)
    {
        $this->name     = $name;
        $this->email    = $email;
        $this->password = $password;
        $this->phone    = $phone;
        $this->role     = $role;
    }
}
