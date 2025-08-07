<?php

namespace App\Services\Attendance;



use App\DTOs\Attendance\CheckInDTO;
use App\DTOs\Attendance\CheckOutDTO;
use App\Filters\Attendance\AttendanceFilter;
use App\Models\Attendance;
use App\Services\ErrorLogging\ErrorLoggingService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Throwable;

class AttendanceService
{
    public function checkIn(CheckInDTO $dto): array
    {
        try {
            $attendance = Attendance::where('user_id', $dto->user_id)
                ->whereDate('check_in', Carbon::today())
                ->first();

            if ($attendance) {

                $attendance->check_in = Carbon::now();
                $attendance->save();

                return [
                    'status' => 'updated',
                    'attendance' => $attendance,
                    'message' => 'Check-in time updated.'
                ];
            }

            $attendance = Attendance::create([
                'user_id' => $dto->user_id,
                'check_in' => Carbon::now(),
            ]);

            return [
                'status' => 'created',
                'attendance' => $attendance,
                'message' => 'Check-in successful.'
            ];
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);

            return [
                'status' => 'error',
                'attendance' => null,
                'message' => 'Failed to check in.'
            ];
        }
    }

    public function checkOut(CheckOutDTO $dto): array
    {
        try {
            $attendance = Attendance::where('user_id', $dto->user_id)
                ->whereDate('check_in', Carbon::today())
                ->first();

            if (!$attendance) {
                return [
                    'status' => 'not_checked_in',
                    'attendance' => null,
                    'message' => 'You have not checked in yet.'
                ];
            }

            $checkInTime = Carbon::parse($attendance->check_in);
            $checkOutTime = Carbon::now();

            $attendance->check_out = $checkOutTime;
            $attendance->worked_minutes = $checkInTime->diffInMinutes($checkOutTime);
            $attendance->save();

            return [
                'status' => $attendance->wasChanged() ? 'updated' : 'created',
                'attendance' => $attendance,
                'message' => 'Check-out ' . ($attendance->wasChanged() ? 'updated' : 'successful') . '.'
            ];
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);

            return [
                'status' => 'error',
                'attendance' => null,
                'message' => 'Failed to check out.'
            ];
        }
    }
    public function list(Request $request)
    {
        $query = Attendance::with(['user.roles']);

        $query = app(Pipeline::class)
            ->send($query)
            ->through([
                fn ($query) => (new AttendanceFilter($request))->apply($query),
            ])
            ->thenReturn();

        $perPage = $request->get('per_page', 10);

        return $query->orderByDesc('check_in')->paginate($perPage);
    }
}
