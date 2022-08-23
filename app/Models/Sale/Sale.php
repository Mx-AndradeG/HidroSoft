<?php

namespace App\Models\Sale;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SaleRelationships;
    use SaleAccessors;
    use SaleActions;

    public CONST WEEK = 1;
    public CONST FORTNIGHT = 2;
    public CONST MONTH = 3;

    public CONST DEADLINETREE = 1;
    public CONST DEADLINESIX = 2;
    public CONST DEADLINETWELVE = 3;

    //Sale status
    public CONST STATUS_PAID = 1;
    public CONST STATUS_WITHOUT_PAYMENT = 2;
    public CONST STATUS_PARTIALLY_PAID = 3;



    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'sales';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'branch_id',
        'customer_id',
        'payment_method_id',
        'total_sale',
        'received_amount',
        'reference_code',
        'sale_type_id'
    ];
}
