<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PayslipExport implements FromArray, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected Payroll $payroll;

    public function __construct(Payroll $payroll)
    {
        $this->payroll = $payroll;
    }

    public function array(): array
    {
        return [[
            'Employee Name' => $this->payroll->user->name,
            'Month' => $this->payroll->month,
            'Basic Pay' => $this->payroll->basic_pay,
            'Bonuses' => $this->payroll->bonuses,
            'Deductions' => $this->payroll->deductions,
            'Net Salary' => $this->payroll->net_salary,
        ]];
    }

    public function headings(): array
    {
        return [
            'Employee Name',
            'Month',
            'Basic Pay',
            'Bonuses',
            'Deductions',
            'Net Salary',
        ];
    }
}
