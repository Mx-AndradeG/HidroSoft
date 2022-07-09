<?php

namespace App\Models\SaleDetails;

use App\Models\Products\Product;
use App\Models\Sale\Sale;

trait SaleDetailRelationships
{
    public function sale(){
        return $this->hasOne(Sale::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
