<?php

namespace App\Http\Resources\Payroll;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PayrollResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
          'Payroll ID'=>$this->id,
            'User ID'=>$this->user_id,
            'Basic Pay'=>$this->basic_pay,
            'Bonuses'=>$this->bonuses,
            'Net Salary'=>$this->net_salary,
            'Pay Date'=>$this->pay_date,
        ];
    }
}
