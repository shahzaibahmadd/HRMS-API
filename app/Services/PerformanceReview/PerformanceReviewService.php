<?php

namespace App\Services\PerformanceReview;

use App\DTOs\PerformanceReview\PerformanceReviewDTO;
use App\Filters\PerformanceReview\PerformanceReviewFilter;
use App\Models\PerformanceReview;
use App\Services\ErrorLogging\ErrorLoggingService;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;

class PerformanceReviewService
{

    public function calculateRatingFromTasks(int $userId): int
    {
        $totalTasks = \App\Models\Task::where('assigned_to', $userId)->count();
        $completedTasks = \App\Models\Task::where('assigned_to', $userId)
            ->where('status', 'completed')->count();

        if ($totalTasks === 0) return 1;

        $percentage = ($completedTasks / $totalTasks) * 100;

        return match (true) {
            $percentage >= 90 => 5,
            $percentage >= 75 => 4,
            $percentage >= 60 => 3,
            $percentage >= 40 => 2,
            default => 1,
        };
    }
    public function create(PerformanceReviewDTO $dto,int $userId): ?PerformanceReview
    {
        try {
            $rating=$this->calculateRatingFromTasks($userId);
            $dto->rating=$rating;
            return PerformanceReview::create($dto->toArray());
        } catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return null;
        }
    }
    public function update(PerformanceReview $performanceReview,PerformanceReviewDTO $dto):?PerformanceReview
    {
            try {
                $performanceReview->update($dto->toArray());
                return $performanceReview;
            } catch (\Throwable $e) {
                ErrorLoggingService::log($e);
                return null;
            }
    }
    public function delete(PerformanceReview $performanceReview):void
    {
        try{
            $performanceReview->delete();
        }
        catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return;
        }
    }
    public function ListAll(Request $request)
    {

        try{
            $query=PerformanceReview::with('user.roles')->latest();
            $query=app(Pipeline::class)->send($query)->through([
                fn($query)=>(new PerformanceReviewFilter($request))->apply($query),
            ])->thenReturn();
            $per_page = $request->get('per_page', 10);
            return $query->paginate($per_page);

        }catch (\Throwable $e) {
            ErrorLoggingService::log($e);
            return collect();
        }

    }

}
