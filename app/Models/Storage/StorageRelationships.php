<?php

namespace App\Models\Storage;

use App\Models\Branch\Branch;
use App\Models\PaymentMethod\PaymentMethod;

trait StorageRelationships
{
    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
