<?php

namespace App\Models\InventoryMovementType;

use App\Models\Categories\Category;
use App\Models\Supplier\Supplier;

trait InventoryMovementTypeRelationships
{
    public function category(){
        return $this->belongsTo(Category::class);
    }

}
