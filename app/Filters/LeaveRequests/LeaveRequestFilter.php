<?php

namespace App\Filters\LeaveRequests;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class LeaveRequestFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
        if ($status = $this->request->get('status')) {
            $query->where('status', $status);
        }

        if ($start = $this->request->get('start_date')) {
            $query->whereDate('start_date', '>=', $start);
        }

        if ($end = $this->request->get('end_date')) {
            $query->whereDate('end_date', '<=', $end);
        }

        if ($userId = $this->request->get('user_id')) {
            $query->where('user_id', $userId);
        }

        if ($role = $this->request->get('role')) {
            $query->whereHas('user.roles', fn($q) => $q->where('name', $role));
        }

        return $query;
    }
}
