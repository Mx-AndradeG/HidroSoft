<?php

namespace App\Models\Payments\Payments;

use App\Models\Agents\Agents\Agent;
use App\Models\finances\Loans\Loan;
use App\Models\finances\product\Product;
use App\Models\Customers\Customers\Customer;
use App\Models\finances\Payments\PaymentDates\PaymentDate;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PaymentRelationships
{
    public function paymentDate(){
        return $this->belongsTo(PaymentDate::class);
    }
}
