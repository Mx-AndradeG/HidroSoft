<?php

namespace App\Models\SaleDetails;

use Carbon\Carbon;

trait SaleDetailAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : '';
    }
    
}
