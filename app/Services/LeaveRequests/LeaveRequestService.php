<?php

namespace App\Services\LeaveRequests;


use App\DTOs\LeaveRequests\CreateLeaveRequestDTO;
use App\DTOs\LeaveRequests\UpdateLeaveStatusDTO;
use App\Filters\LeaveRequests\LeaveRequestFilter;
use App\Models\LeaveRequest;


use App\Services\ErrorLogging\ErrorLoggingService;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Throwable;

class LeaveRequestService
{
    public function create(CreateLeaveRequestDTO $dto): ?LeaveRequest
    {
        try {
            return LeaveRequest::create($dto->toArray());
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function updateStatus(UpdateLeaveStatusDTO $dto): ?LeaveRequest
    {
        try {
            $leave = LeaveRequest::find($dto->leave_id);

            if (!$leave) return null;

            $leave->status = $dto->status;
            $leave->admin_note = $dto->admin_note ?? $leave->admin_note;
            $leave->save();

            return $leave;
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function getUserLeaves(int $userId)
    {
        return LeaveRequest::where('user_id', $userId)->latest()->get();
    }

    public function getAllPending()
    {
        return LeaveRequest::where('status', 'pending')->latest()->get();
    }
    public function listAll(Request $request)
    {
        try {
            $query = LeaveRequest::with('user.roles')->latest();

            $query=app(Pipeline::class)->send($query)->through([
                fn ($query) => (new LeaveRequestFilter($request))->apply($query),
            ])->thenReturn();

            $perPage = $request->get('per_page', 10);

            return $query->paginate($perPage);
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return collect();
        }
}

      public function delete(LeaveRequest $leaveRequest):void
      {

          try {
              $leaveRequest->delete();
          }catch (Throwable $e) {
              ErrorLoggingService::log($e);
              return;
          }
      }
}
