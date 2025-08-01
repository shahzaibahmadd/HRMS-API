<?php

namespace App\Filters\Task;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class TaskFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
        if($status=$this->request->get('status')){
            $query->where('status', $status);
        }
        if($due_date=$this->request->get('due_date')){
            $query->where('due_date', $due_date);
        }
        if($assigned_by=$this->request->get('assigned_by')){
            $query->where('assigned_by', $assigned_by);
        }
        if($assigned_to=$this->request->get('assigned_to')){
            $query->where('assigned_to', $assigned_to);
        }
        if($description=$this->request->get('description')){
            $query->where('description', $description);
        }
        if($title=$this->request->get('title')){
            $query->where('title', $title);
        }
        if($id=$this->request->get('id')){
            $query->where('id', $id);
        }

        return $query;

    }
}
