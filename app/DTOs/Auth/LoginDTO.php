<?php

namespace App\DTOs\Auth;

use App\DTOs\BaseDTO;

class LoginDTO extends BaseDTO
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {

        $this->email = $email;
        $this->password = $password;
    }

}
