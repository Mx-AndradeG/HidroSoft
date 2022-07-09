<?php

namespace App\Models\Sale;

use Carbon\Carbon;

trait SaleAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getUserNameAttribute()
    {
        return $this->user ? $this->user->name : '';
    }

    public function getBranchNameAttribute()
    {
        return $this->branch ? $this->branch->name : '';
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer ? $this->customer->name : 'Publico en general';
    }

    public function getPaymentMethodNameAttribute()
    {
        return $this->payment_method ? $this->payment_method->name : '';
    }    

    public function getFormattedRecievedAmountAttribute()
    {
        return  $this->received_amount ? '$'. number_format($this->received_amount, 2, '.', ',') : 'No se recibió pago en efectivo';
    }

    public function getFormattedTotalSaleAttribute()
    {
        return '$' . number_format($this->total_sale, 2, '.', ',');
    }

    public function getSaleFormattDetailsAttribute()
    {
        $data = [];
        foreach ($this->sale_detail as $sale){
            array_push($data, [
                'product_name' => $sale->product->name,
                'quantity' => $sale->quantity,
                'price' => '$'. number_format($sale->price, 2, '.', ','),
                'subtotal' => '$'. number_format(($sale->price * $sale->quantity),2, '.', ','),
            ]);
        };
        return $data;
    }
    
}
