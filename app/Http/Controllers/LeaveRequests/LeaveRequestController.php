<?php

namespace App\Http\Controllers\LeaveRequests;



use App\DTOs\LeaveRequests\CreateLeaveRequestDTO;
use App\DTOs\LeaveRequests\UpdateLeaveStatusDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;

use App\Http\Requests\LeaveRequests\StoreLeaveRequest;
use App\Http\Requests\LeaveRequests\UpdateLeaveStatusRequest;
use App\Http\Resources\LeaveRequests\LeaveRequestResource;
use App\Models\LeaveRequest;
use App\Services\ErrorLogging\ErrorLoggingService;
use App\Services\LeaveRequests\LeaveRequestService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveRequestController extends Controller
{
    public function __construct(protected LeaveRequestService $leaveService) {}

    public function store(StoreLeaveRequest $request)
    {
        $dto = new CreateLeaveRequestDTO(
            auth()->id(),
           ...$request->toarray()
        );

        $leave = $this->leaveService->create($dto);

        return $leave
            ? ResponseHelper::success(new LeaveRequestResource($leave), "Leave requested successfully.")
            : ResponseHelper::error("Failed to submit leave request.");
    }

    public function updateStatus(UpdateLeaveStatusRequest $request, $id)
    {
        $dto = new UpdateLeaveStatusDTO($id, $request->status, $request->admin_note);

        $leave = $this->leaveService->updateStatus($dto);

        return $leave
            ? ResponseHelper::success(new LeaveRequestResource($leave), "Leave status updated.")
            : ResponseHelper::error("Leave request not found or could not be updated.");
    }

    public function myLeaves()
    {
        $leaves = $this->leaveService->getUserLeaves(auth()->id());
        return ResponseHelper::success(LeaveRequestResource::collection($leaves));
    }

    public function pendingLeaves()
    {
        $leaves = $this->leaveService->getAllPending();
        return ResponseHelper::success(LeaveRequestResource::collection($leaves));
    }

    public function index(Request $request)
    {
        $leaves = $this->leaveService->listAll($request);
        return ResponseHelper::success(LeaveRequestResource::collection($leaves));
    }
    public function destroy(LeaveRequest $leaveRequest)
    {
        try {
            $user=Auth::user();
            if(!$user->hasrole('Admin')){
                return ResponseHelper::error("You do not have permission to perform this action");
            }
            $this->leaveService->delete($leaveRequest);
            return ResponseHelper::success("Leave request deleted successfully.");


        }catch (\Throwable $e) {
            ErrorLoggingService::log($e);

        }
     }
}

