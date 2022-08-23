<?php


namespace App\Models\Payments\PaymentDates;

use Carbon\Carbon;


trait PaymentDateAccessors
{
    public function getCustomerNameAttribute(){
        return $this->customer ? $this->customer->full_user_name : "";
    }
    
    public function getAgentNameAttribute(){
        return $this->agent ? $this->agent->full_user_name : "";
    }
    
    public function getProductNameAttribute(){
        return $this->product ? $this->product->name : "";
    }

    public function getCheckStatusAttribute(){
        if($this->amount === $this->total_paid)
            return 'Pagado';
        if($this->date < now()->toDateString())
            return 'Vencido';
        if($this->date > now()->toDateString())
            return 'Vigente';
    }

}
