<?php

namespace App\Models\Branch;

use App\Models\PaymentMethod\PaymentMethod;

trait BranchRelationships
{
    public function payment_methods()
    {
        return $this->belongsToMany(PaymentMethod::class)->withTimestamps();
    }
}
