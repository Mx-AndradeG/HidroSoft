<?php

namespace App\Models\Notifications;

use Carbon\Carbon;
use Faker\Core\Number;

trait NotificationAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : '';
    }
    public function getStorageNameAttribute()
    {
        return $this->storage ? $this->storage->name : '';

    }
}
