<?php

namespace App\Models\PaymentMethod;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    const CASH = '1';
    const CARD = '2';

    use HasFactory;
    use SoftDeletes;
    use PaymentMethodRelationships;
    use PaymentMethodAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'payment_methods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
}
