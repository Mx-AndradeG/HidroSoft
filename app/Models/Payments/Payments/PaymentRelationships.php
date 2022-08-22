<?php

namespace App\Models\Payments\Payments;

use App\Models\Payments\PaymentDates\PaymentDate;

trait PaymentRelationships
{
    public function paymentDate(){
        return $this->belongsTo(PaymentDate::class);
    }
}
