<?php

namespace App\Models\SaleType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use SaleTypeRelationships;
    use SaleTypeAccessors;
    use SaleTypeActions;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'sale_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
