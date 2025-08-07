<?php

namespace App\Http\Resources\Attendance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
//        return [
//            'id' => $this->id,
//            'check_in' => $this->check_in,
//            'check_out' => $this->check_out,
//            'worked_minutes' => $this->worked_minutes,
//            'user' => [
//                'id' => $this->user->id,
//                'name' => $this->user->name,
//                'email' => $this->user->email,
//            ]
//        ];
        return [
            'id' => $this->id,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'worked_minutes' => $this->worked_minutes,
            'user' => $this->whenLoaded('user', [
                'id' => $this->user?->id,
                'name' => $this->user?->name,
                'email' => $this->user?->email,
            ]),
        ];
    }
}
