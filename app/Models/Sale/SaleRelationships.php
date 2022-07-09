<?php

namespace App\Models\Sale;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\SaleDetails\SaleDetail;
use App\Models\User;

trait SaleRelationships
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
    
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    
    public function payment_method(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function sale_detail(){
        return $this->hasMany(SaleDetail::class);
    }
}
