<?php

namespace App\Http\Resources\LeaveRequests;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'user_id'     => $this->user_id,
            'user_name'   => $this->user->name,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'reason'      => $this->reason,
            'status'      => $this->status,
            'admin_note'  => $this->admin_note,
            'created_at'  => $this->created_at->toDateTimeString(),
        ];
    }
}
