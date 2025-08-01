<?php

namespace App\Filters\PerformanceReview;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class PerformanceReviewFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
        if($id=$this->request->get('id')){
            $query=$query->where('id',$id);
        }
        if($user_id=$this->request->get('user_id')){
            $query=$query->where('user_id',$user_id);
        }
        if($rating=$this->request->get('rating')){
            $query=$query->where('rating',$rating);
        }
        if($feedback=$this->request->get('feedback')){
            $query=$query->where('feedback',$feedback);
        }
        if($review_date=$this->request->get('review_date')){
            $query=$query->where('review_date',$review_date);
        }

        return $query;
    }
}
