<?php

namespace App\Models\Log;

use Carbon\Carbon;

trait LogAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }
    
    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : '';
    }
}
