<?php


namespace App\Models\Payments\Payments;


trait PaymentAccessors
{
    function getCustomerNameAttribute(){
        
        return $this->paymentDate->loan->customer ? $this->paymentDate->loan->customer->full_user_name :"No tiene";
    }
    function getAgentNameAttribute(){

        return $this->paymentDate->loan->agent->user ? $this->paymentDate->loan->agent->user->full_user_name :"No tiene";
    }
    function getProductNameAttribute(){
        return $this->paymentDate->loan->product ? $this->paymentDate->loan->product->name :"No tiene";
    }
    function getFormatAmountAttribute(){
        return $this->amount ? '$'.$this->amount : "No tiene";
    }
    function getPaymentDateDateAttribute(){
        return $this->paymentDate->date;
    }
    function getLoanIdAttribute(){
        return $this->paymentDate->loan->id;
    }
}
