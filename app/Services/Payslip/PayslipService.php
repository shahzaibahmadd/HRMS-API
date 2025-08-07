<?php

namespace App\Services\Payslip;

use App\Models\Payroll;
use App\Models\Payslip;
use App\Exports\PayslipExport;
use App\Services\ErrorLogging\ErrorLoggingService;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class PayslipService
{
    public function generate(Payroll $payroll): ?Payslip
    {
        try {
            $filename = 'payslip_' . $payroll->id . '_' . now()->format('YmdHis') . '.xlsx';
            $filePath = 'payslips/' . $filename;


            Excel::store(new PayslipExport($payroll), $filePath, 'public');


            if ($payroll->payslip) {
                Storage::disk('public')->delete($payroll->payslip->file_path);
                $payroll->payslip->delete();
            }


            return Payslip::create([
                'payroll_id' => $payroll->id,
                'file_path'  => $filePath,
            ]);
        } catch (Throwable $e) {
            ErrorLoggingService::log($e);
            return null;
        }
    }

    public function download(Payslip $payslip)
    {
        if (!Storage::disk('public')->exists($payslip->file_path)) {
            return null;
        }

        return Storage::disk('public')->download($payslip->file_path);
    }
}
