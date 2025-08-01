<?php

namespace App\Http\Controllers\Payroll;

use App\DTOs\Payroll\CreatePayrollDTO;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Payroll\CreatePayrollRequest;
use App\Http\Resources\Payroll\PayrollResource;
use App\services\Payroll\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function __construct(protected PayrollService $payrollService) {}

    public function store(CreatePayrollRequest $request)
    {
        $dto = new CreatePayrollDTO($request);
        $payroll = $this->payrollService->create($dto);

        if (!$payroll) {
            return ResponseHelper::error("Failed to create payroll.");
        }

        return ResponseHelper::success($payroll, "Payroll created successfully.");
    }

    public function show($userId)
    {
        $payroll = $this->payrollService->getByUser($userId);

        if (!$payroll) {
            return ResponseHelper::error("Payroll not found.", 404);
        }

        return ResponseHelper::success($payroll);
    }
    public function index(Request $request)
    {
        $payrolls=$this->payrollService->ListAll($request);
        return ResponseHelper::success(PayrollResource::collection($payrolls), "Payroll list");
    }
}
