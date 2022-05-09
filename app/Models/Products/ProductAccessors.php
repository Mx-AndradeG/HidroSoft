<?php

namespace App\Models\Products;

use Carbon\Carbon;

trait ProductAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->name : 'asdas';
    }
    
}
