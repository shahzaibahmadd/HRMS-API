<?php

namespace App\Filters\payroll;

use App\Filters\BaseFilter;
use Illuminate\Database\Eloquent\Builder;

class PayrollFilter extends BaseFilter
{

    public function apply(Builder $query): Builder
    {
        if($id=$this->request->get('id')){
            $query=$query->where('id',$id);
        }
        if($user_id=$this->request->get('user_id')){
            $query=$query->where('user_id',$user_id);
        }
        if($basic_pay=$this->request->get('basic_pay')){
            $query=$query->where('basic_pay',$basic_pay);
        }
        if($bonuses=$this->request->get('bonuses')){
            $query=$query->where('bonuses',$bonuses);
        }
        if($deductions=$this->request->get('deductions')){
            $query=$query->where('deductions',$deductions);
        }
        if($net_salary=$this->request->get('net_salary')){
            $query=$query->where('net_salary',$net_salary);
        }
        if($pay_date=$this->request->get('pay_date')){
            $query=$query->where('pay_date',$pay_date);
        }
        return $query;
    }
}
