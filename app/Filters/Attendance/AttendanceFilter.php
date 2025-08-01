<?php

namespace App\Filters\Attendance;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class AttendanceFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
        if ($userId = $this->request->get('user_id')) {
            $query->where('user_id', $userId);
        }

        if ($date = $this->request->get('date')) {
            $query->whereDate('check_in', $date);
        }

        if ($role = $this->request->get('role')) {
            $query->whereHas('user.roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        return $query;
    }
}
