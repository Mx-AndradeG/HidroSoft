<?php

namespace App\Models\InventoryMovementType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryMovementType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use InventoryMovementTypeRelationships;

    const ENTRY = 1; 
    const OUTPUT = 2; 
    const TRANSFER = 3; 
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'inventory_movement_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
