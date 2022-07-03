<?php

namespace App\Models\InventoryMovement;

use Carbon\Carbon;

trait InventoryMovementAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getInventoryMovementTypeNameAttribute()
    {
        return $this->inventory_movement_type ? $this->inventory_movement_type->name : '';
    }

    public function getAllMovementsAttribute()
    {
        return $this->inventory_movement_product->map(function ($q){
            return [
                'id' => $q->id,
                'storage_id' => $q->storage_id,
                'product_id' => $q->product_id,
                'quantity' => $q->quantity,
            ]; 
        });
    }


    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }
}
