<?php

namespace App\Models\Payments\PaymentDates;

use App\Models\finances\Loans\Loan;
use App\Models\finances\Payments\Payments\Payment;

trait PaymentDateRelationships
{
    public function loan(){
        return $this->belongsTo(Loan::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }

}
