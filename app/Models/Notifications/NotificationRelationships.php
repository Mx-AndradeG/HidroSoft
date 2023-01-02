<?php

namespace App\Models\Notifications;

use App\Models\Products\Product;
use App\Models\Storage\Storage;
use App\Models\User;

trait NotificationRelationships
{
    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function storage(){
        return $this->belongsTo(Storage::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
