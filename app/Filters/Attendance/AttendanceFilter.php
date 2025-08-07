<?php

namespace App\Filters\Attendance;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class AttendanceFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
        if ($this->request->filled('user_id')) {
            $query->where('user_id', $this->request->user_id);
        }

        if ($this->request->filled('date')) {
            $query->whereDate('check_in', $this->request->date);
        }

        if ($this->request->filled('role')) {
            $query->whereHas('user.roles', function ($q) {
                $q->where('name', $this->request->role);
            });
        }

        return $query;
    }

}
