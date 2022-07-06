<?php

namespace App\Models\Storage;

use App\Models\Stock\Stock;
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

    public function getHasStockAttribute()
    {
        $quantity = Stock::where('storage_id', $this->id)->where('quantity', '>' , 0 )->sum('quantity');
        return $quantity > 0 ? true : false;
    }

}