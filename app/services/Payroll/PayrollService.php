<?php

namespace App\services\Payroll;

use App\DTOs\Payroll\CreatePayrollDTO;
use App\DTOs\Payroll\UpdatePayrollDTO;
use App\Filters\payroll\PayrollFilter;
use App\Models\Payroll;
use App\services\ErrorLogging\ErrorLoggingService;
use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Throwable;

class PayrollService
{

    public function create(CreatePayrollDTO $dto): ?Payroll
    {
        try {
            return Payroll::create($dto->toArray());
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function getByUser(int $userId): ?Payroll
    {
        return Payroll::where('user_id', $userId)->latest()->first();
    }
    public function ListAll(Request $request){
        try{

            $query = Payroll::with('user.roles')->latest();
            $query=app(Pipeline::class)->send($query)->through([
                fn ($query) => (new PayrollFilter($request))->apply($query),
            ])->thenReturn();
            $per_page = $request->get('per_page', 10);
            return $query->paginate($per_page);
        }catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return collect();
        }
    }
    public function update(UpdatePayrollDTO $dto)
    {
        try {
            $payroll = Payroll::find($dto->payroll_id);

            if (!$payroll) {
                return null;
            }

            $payroll->update([
                'user_id' => $dto->user_id,
                'basic_pay' => $dto->basic_pay,
                'bonuses' => $dto->bonuses,
                'deductions' => $dto->deductions,
                'net_salary' => $dto->net_salary,
                'pay_date' => $dto->pay_date,
            ]);

            return $payroll;
        } catch (\Exception $e) {
            app(ErrorLoggingService::class)->log($e);
            return null;
        }
    }
}
