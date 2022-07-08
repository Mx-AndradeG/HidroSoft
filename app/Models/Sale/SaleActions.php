<?php

namespace App\Models\Sale;

use App\Models\SaleDetails\SaleDetail;
use Carbon\Carbon;

trait SaleActions
{
   public function storeSaleDetails($products)
   {
     foreach($products as $product)
     {
       $saleDetail = new SaleDetail();
       $saleDetail->sale_id = $this->id;
       $saleDetail->product_id = $product['product_id'];
       $saleDetail->quantity = $product['quantity_to_sale'];
       $saleDetail->price = $product['product_price'];
       $saleDetail->save();
     }
   }
    
}
