<?php

namespace App\Http\Resources\Announcement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
          'id'=>$this->id,
            'title'=>$this->title,
            'message'=>$this->message,
            'is_active'=>$this->is_active,
            'created'=>$this->created_at?->toDateTimeString(),
        ];
    }
}
