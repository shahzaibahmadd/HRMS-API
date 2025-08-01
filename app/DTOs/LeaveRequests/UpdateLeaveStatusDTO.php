<?php

namespace App\DTOs\LeaveRequests;

use App\DTOs\BaseDTO;

class UpdateLeaveStatusDTO extends BaseDTO
{
    public function __construct(
        public int $leave_id,
        public string $status,
        public ?string $admin_note = null
    ) {}
}
