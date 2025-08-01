<?php

// app/Http/Controllers/Attendance/AttendanceController.php

namespace App\Http\Controllers\Attendance;

use App\DTOs\Attendance\CheckInDTO;
use App\DTOs\Attendance\CheckOutDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Services\Attendance\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(protected AttendanceService $attendanceService) {}

    public function checkIn()
    {
        $dto = new CheckInDTO(auth()->id());
        $result = $this->attendanceService->checkIn($dto);

        if ($result['status'] === 'error') {
            return ResponseHelper::error($result['message']);
        }

        return ResponseHelper::success(
            new AttendanceResource($result['attendance']),
            $result['message']
        );
    }

    public function checkOut()
    {
        $dto = new CheckOutDTO(auth()->id());
        $result = $this->attendanceService->checkOut($dto);

        if (in_array($result['status'], ['error', 'not_checked_in'])) {
            return ResponseHelper::error($result['message']);
        }

        return ResponseHelper::success(
            new AttendanceResource($result['attendance']),
            $result['message']
        );
    }

    public function index(Request $request)
    {
        $attendances = $this->attendanceService->list($request);
        return ResponseHelper::success(AttendanceResource::collection($attendances));
    }
}
