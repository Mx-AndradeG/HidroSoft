<?php

namespace App\Models\PaymentMethod;

use App\Models\Branch\Branch;

trait PaymentMethodRelationships
{
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
