<?php

namespace App\DTOs\LeaveRequests;

use App\DTOs\BaseDTO;

class CreateLeaveRequestDTO extends BaseDTO
{

    public function __construct(
        public int $user_id,
        public string $start_date,
        public string $end_date,
        public ?string $reason = null
    ) {}
}
