<?php

namespace App\Models\Products;

use App\Models\Categories\Category;

trait ProductRelationships
{
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
