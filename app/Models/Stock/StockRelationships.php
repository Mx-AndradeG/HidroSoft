<?php

namespace App\Models\Stock;

use App\Models\Categories\Category;
use App\Models\Supplier\Supplier;

trait StockRelationships
{
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
