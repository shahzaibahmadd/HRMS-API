<?php

namespace App\DTOs\Payroll;

use App\DTOs\BaseDTO;
use Illuminate\Http\Request;

class UpdatePayrollDTO extends BaseDTO
{

    public int $payroll_id;
    public int $user_id;
    public float $basic_pay;
    public float $bonuses;
    public float $deductions;
    public float $net_salary;
    public string $pay_date;

    public function __construct(Request $request, int $payrollId)
    {
        $this->payroll_id = $payrollId;
        $this->user_id = (int) $request->user_id;
        $this->basic_pay = (float) $request->basic_pay;
        $this->bonuses = (float) $request->bonuses ?? 0;
        $this->deductions = (float) $request->deductions ?? 0;
        $this->net_salary = $this->basic_pay + $this->bonuses - $this->deductions;
        $this->pay_date = $request->pay_date;
    }
}
