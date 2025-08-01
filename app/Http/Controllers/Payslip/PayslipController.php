<?php

namespace App\Http\Controllers\Payslip;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\Payslip;
use App\services\Payslip\PayslipService;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    public function __construct(protected PayslipService $payslipService) {}

    public function generate(Payroll $payroll)
    {
        $payslip = $this->payslipService->generate($payroll);

        if (!$payslip) {
            return ResponseHelper::error("Payslip generation failed.");
        }

        return ResponseHelper::success($payslip, "Payslip generated.");
    }

    public function download(Payslip $payslip)
    {
        $download = $this->payslipService->download($payslip);

        if (!$download) {
            return ResponseHelper::error("Payslip file not found.");
        }

        return $download;
    }
}
