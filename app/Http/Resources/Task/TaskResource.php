<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
          'task_no'=>$this->id,
            'task title'=>$this->title,
            'Assigned By'=>$this->assigned_by,
            'Assigned To'=>$this->assigned_to,
            'Description'=>$this->description,
            'Status of Task'=>$this->status,
            'due date'=>$this->due_date,
        ];
    }
}
