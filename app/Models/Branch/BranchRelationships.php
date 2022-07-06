<?php

namespace App\Models\Branch;

use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Storage\Storage;

trait BranchRelationships
{
    public function payment_methods(){
        return $this->belongsTo(PaymentMethod::class);
    }
    public function storage(){
        return $this->hasOne(Storage::class);
    }
}
