<?php

namespace App\Models\InventoryMovement;

use App\Models\InventoryMovementProduct\InventoryMovementProduct;
use App\Models\InventoryMovementType\InventoryMovementType;

trait InventoryMovementRelationships
{
    public function inventory_movement_type(){
        return $this->belongsTo(InventoryMovementType::class);
    }
    
    public function inventory_movement_product()
    {
        return $this->hasMany(InventoryMovementProduct::class);
    }

}
