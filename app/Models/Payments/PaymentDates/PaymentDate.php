<?php

namespace App\Models\Payments\PaymentDates;
use App\Models\Logs\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Accessors\HasFormattedTimestampsTrait;

class PaymentDate extends Model
{
    use HasFactory, SoftDeletes, PaymentDateRelationships, PaymentDateAccessors, Actions;

    /**
     * The table associated with the model.
     *  
     * @var string
     */
    public $table = 'payment_dates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'amount',
        'sale_id',
    ];

    

   

}
