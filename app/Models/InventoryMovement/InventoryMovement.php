<?php

namespace App\Models\InventoryMovement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMovement extends Model
{
    use HasFactory;
    use SoftDeletes;
    use InventoryMovementRelationships;
    use InventoryMovementAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'inventory_movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'inventory_movement_type_id',
        'user_id',
    ];
}
