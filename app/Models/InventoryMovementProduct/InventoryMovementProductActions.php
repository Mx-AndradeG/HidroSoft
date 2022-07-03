<?php

namespace App\Models\InventoryMovementProduct;

use App\Models\Stock\Stock;
use Carbon\Carbon;

trait InventoryMovementProductActions
{
    public function addStock(){
        $stock = Stock::where('product_id', $this->product_id)
            ->where('storage_id', $this->storage_id)
            ->first();
        if($stock){
            $stock->quantity += $this->quantity;
            $stock->save();
        }else{
            $stock = new Stock();
            $stock->product_id = $this->product_id;
            $stock->storage_id = $this->storage_id;
            $stock->quantity = $this->quantity;
            $stock->save();
        }
        
        return $stock;
    }
}
