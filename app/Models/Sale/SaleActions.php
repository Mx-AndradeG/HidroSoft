<?php

namespace App\Models\Sale;

use App\Models\Products\Product;
use App\Models\SaleDetails\SaleDetail;
use App\Models\Stock\Stock;
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
       $saleDetail->purchase_price =  Product::findOrFail($product['product_id'])->purchase_price;
       $saleDetail->save();
       $this->updateStock($saleDetail->product_id, $saleDetail->quantity);
     }
   }

   public function updateStock($product_id, $quantity){
      $storage_id = $this->branch->storage->id;
      $stock = Stock::where('product_id', $product_id)->where('storage_id', $storage_id)->first();
      $stock->quantity -= $quantity;
      $stock->save();
  }
}