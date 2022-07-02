<?php

namespace App\Models\InventoryMovementProduct;

use App\Models\Categories\Category;
use App\Models\Supplier\Supplier;

trait InventoryMovementProductRelationships
{
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
