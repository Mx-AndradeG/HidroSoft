<?php

namespace App\Models\InventoryMovementProduct;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMovementProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    use InventoryMovementProductRelationships;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'inventory_movement_product';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_movement_id',
        'product_id',
        'storage_id',
        'quantity',
    ];
}
