<?php

namespace App\Models\Branch;

use App\Models\Company\Company;
use Carbon\Carbon;

trait BranchAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getHasStorageAttribute()
    {
        return $this->storage ? true : false;
    }
}
