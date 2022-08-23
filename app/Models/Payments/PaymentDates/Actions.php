<?php

namespace App\Models\Payments\PaymentDates;

use Carbon\Carbon;
use App\Models\finances\PaymentTypes\PaymentType;
use App\Models\finances\Payments\PaymentDates\PaymentDate;

trait Actions
{
    public function getFormatPaymetsDates(){
    $state = ''; 
    $payments =  $this->payment;
    $total_paid = 0;
    foreach($payments as $payment){
        $total_paid+=$payment->amount;
    }
    if ($total_paid == $this->amount)
      $state='Liquidado';
    if ($total_paid < $this->amount && now()->toDateString() > $this->date )
      $state = 'Vencido';    
    if ($total_paid < $this->amount && now()->toDateString() < $this->date )
      $state = 'Vigente';    

    $data = [
      "id"          => $this->id,
      "date"        => $this->date,
      "amount"      => $this->amount,
      "total_paid"  => $this->total_paid,
      "state"       => $state,  
    ]; 

    return $data;
  }
}
