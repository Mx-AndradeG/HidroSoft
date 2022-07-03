<?php

namespace App\Models\Stock;

use App\Models\Products\Product;
use App\Models\Storage\Storage;
use App\Models\Supplier\Supplier;

trait StockRelationships
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function storage(){
        return $this->belongsTo(Storage::class);
    }
}
