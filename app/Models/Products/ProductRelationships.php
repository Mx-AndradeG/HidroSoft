<?php

namespace App\Models\Products;

use App\Models\Categories\Category;
use App\Models\Supplier\Supplier;

trait ProductRelationships
{
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
