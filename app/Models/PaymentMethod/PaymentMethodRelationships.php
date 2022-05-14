<?php

namespace App\Models\PaymentMethod;

trait PaymentMethodRelationships
{
    public function branches()
    {
        return $this->belongsToMany(Branch::class)->withTimestamps()
        ->withPivot('name');
    }
}
