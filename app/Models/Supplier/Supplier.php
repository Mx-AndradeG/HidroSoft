<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SupplierRelationships;
    use SupplierAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'phone',
        'address',
        'latitude',
        'longitude',
        'company_id'
    ];
}
