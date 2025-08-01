<?php

namespace App\Filters\User;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class UserFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
       if($name=$this->request->get('name')){
           $query->where('name', 'like', "%$name%");
       }
       if($email=$this->request->get('email')){
           $query->where('email','like',"%$email%");
       }
        if ($role = $this->request->get('role')) {
            $query->whereHas('roles', fn ($q) => $q->where('name', $role));
        }

        if ($isActive = $this->request->get('is_active')) {
            $query->where('is_active', filter_var($isActive, FILTER_VALIDATE_BOOLEAN));
        }

        return $query;

    }
}
