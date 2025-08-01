<?php

namespace App\DTOs\PerformanceReview;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class PerformanceReviewDTO extends BaseDTO
{
    public int $user_id;
        public ?int $rating=null;
        public ?string $feedback;
        public string $review_date;
    public function __construct(Request $request) {
        $this->user_id=$request->user_id;
        $this->rating=$request->rating;
        $this->feedback=$request->feedback;
        $this->review_date=$request->review_date;
    }


}
