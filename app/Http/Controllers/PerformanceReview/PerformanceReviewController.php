<?php

namespace App\Http\Controllers\PerformanceReview;

use App\DTOs\PerformanceReview\PerformanceReviewDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PerformanceReview\PerformanceReviewRequest;
use App\Http\Resources\PerformanceReview\PerformanceReviewResource;
use App\Models\PerformanceReview;
use App\Services\PerformanceReview\PerformanceReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceReviewController extends Controller
{
    public function __construct(protected PerformanceReviewService $performanceReviewService){}

    public function store(PerformanceReviewRequest $request){
        $userId=$request->user_id;

        $dto=new PerformanceReviewDTO($request);
        $performanceReview=$this->performanceReviewService->create($dto,$userId);
        if(!$performanceReview){
            return ResponseHelper::error("Error occured while saving performance review");
        }
        return ResponseHelper::success(new PerformanceReviewResource($performanceReview));
    }
    public function destroy(PerformanceReview $performanceReview){
       $user=Auth::user();
       if(!$user->hasrole('Admin')){
           return ResponseHelper::error("You do not have permission to perform this action");
       }
       $this->performanceReviewService->delete($performanceReview);
       return ResponseHelper::success(new PerformanceReviewResource($performanceReview),"performance review deleted");
    }

    public function update(PerformanceReviewRequest $request,PerformanceReview $performanceReview){
        $user=Auth::user();
        if(!$user->hasrole('Admin')){
            return ResponseHelper::error("You do not have permission to perform this action");
        }
        $dto=new PerformanceReviewDTO($request);
        $performanceReview=$this->performanceReviewService->update($performanceReview,$dto);
        return ResponseHelper::success(new PerformanceReviewResource($performanceReview));

    }
    public function show(PerformanceReview $performanceReview){
        return ResponseHelper::success(new PerformanceReviewResource($performanceReview));
    }
    public function index(Request $request){

        $performanceReview=$this->performanceReviewService->ListAll($request);
        return ResponseHelper::success(PerformanceReviewResource::collection($performanceReview),"Performance review list");
    }
}
