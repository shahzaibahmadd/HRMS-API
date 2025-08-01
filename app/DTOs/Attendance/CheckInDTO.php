<?php

namespace App\DTOs\Attendance;

use App\DTOs\BaseDTO;

class CheckInDTO extends BaseDTO
{

    public int $user_id;

    public function __construct(int $user_id)
    {
        $this->user_id = $user_id;
    }
}
