<?php

namespace App\Http\Resources\PerformanceReview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PerformanceReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'Review ID'=>$this->id,
            'User ID'=>$this->user_id,
            'User Rating'=>$this->rating,
            'User Feedback'=>$this->feedback,
            'Review Date'=>$this->review_date,
        ];
    }
}
