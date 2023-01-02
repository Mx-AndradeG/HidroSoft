<?php

namespace App\Models\Sale;

use App\Models\Branch\Branch;
use App\Models\Notifications\Notification;
use App\Models\Payments\PaymentDates\PaymentDate;
use App\Models\Products\Product;
use App\Models\SaleDetails\SaleDetail;
use App\Models\Stock\Stock;
use App\Models\Storage\Storage;
use App\Models\User;
use App\Models\UserTypes\UserType;
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
      if($stock->quantity == '5' || $stock->quantity == '10' || $stock->quantity == '0'){
        $this->storeNotificationCase($stock);
      }
      $stock->save();
  }

  public function createPaymentDates($payment_plan_id, $total_sale, $deadline_id){

    $current_pay_for_deadline = 0;
    $payments = [];
    $times_to_paid = 0;

    switch ($deadline_id) {
        case Sale::DEADLINETREE:
            $times_to_paid = 3;
            $current_pay_for_deadline = $total_sale / $times_to_paid;
            break;
        case Sale::DEADLINESIX:
            $times_to_paid = 6;
            $current_pay_for_deadline = $total_sale / $times_to_paid;

            break;
        case Sale::DEADLINETWELVE:
            $times_to_paid = 12;
            $current_pay_for_deadline = $total_sale / $times_to_paid;
            break;
        default:
            break;
    }


    switch ($payment_plan_id) {
        case Sale::WEEK:
            $current_date = Carbon::now();
            for ($i = 0; $i < $times_to_paid; $i++) {
                $current_date = $current_date->addWeek();
                array_push($payments, [
                    'date' => $current_date->format('Y-m-d'),
                    'amount' => round($current_pay_for_deadline, 2)
                ]);
            }

            break;
        case Sale::FORTNIGHT:
            $current_date = Carbon::now();
            for ($i = 0; $i < $times_to_paid; $i++) {
                $current_date = $current_date->addDays(15);
                array_push($payments, [
                    'date' => $current_date->format('Y-m-d'),
                    'amount' => round($current_pay_for_deadline, 2),
                ]);
            }
            break;
        case Sale::MONTH:
            $current_date = Carbon::now();
            for ($i = 0; $i < $times_to_paid; $i++) {
                $current_date = $current_date->addMonth();
                array_push($payments, [
                    'date' => $current_date->format('Y-m-d'),
                    'amount' => round($current_pay_for_deadline, 2),
                ]);
            }
            break;
        default:
            break;
    }

    foreach ($payments as $payment) {
        $payment_date = new PaymentDate();
        $payment_date->sale_id = $this->id;
        $payment_date->date = Carbon::parse($payment['date']);
        $payment_date->amount = $payment['amount'];
        $payment_date->total_paid = 0;
        $payment_date->save();
    }

    return $payments;
  }

  public function storeNotificationCase($stock){
    $admins = User::where('branch_id', auth()->user()->branch_id)->get();
    foreach($admins as $user){
        if($user->user_type_id == 1){
            $notification = new Notification();
            $notification->user_id = $user->id;
            $notification->product_id = $stock->product_id;
            $notification->storage_id = $stock->storage_id;
            $product = Product::findOrFail($stock->product_id);
            $storage = Storage::findOrFail($stock->storage_id);
            $notification->menssage = "El producto " . $product->name . " solo quedan: " . 
                          $stock->quantity . ' unidades' . ' en el almacen: ' . $storage->name .  ' contacta con tu proveedor: ' . $product->supplier_name .
                          " a su numero de contacto: " . $product->supplier->phone;
            $notification->save();
        }
    }

  }
}