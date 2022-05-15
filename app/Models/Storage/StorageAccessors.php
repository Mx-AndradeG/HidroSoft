<?php

namespace App\Models\Storage;

use Carbon\Carbon;

trait StorageAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getBranchNameAttribute()
    {
        return $this->branch ? $this->branch->name : '';
    }

}