<?php

namespace App\Models\SaleDetails;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SaleDetailRelationships;
    use SaleDetailAccessors;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'sale_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'quantity',
        'price',
        'purchase_price'
    ];
}
