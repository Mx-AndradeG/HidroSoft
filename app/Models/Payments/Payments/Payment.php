<?php
namespace App\Models\Payments\Payments;

use App\Models\Logs\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Traits\Accessors\HumanDate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\Finances\Payments\PaymentSaved;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Traits\Accessors\HasFormattedTimestampsTrait;

class Payment extends Model
{
    use Notifiable, HasFactory, SoftDeletes, PaymentRelationships, PaymentAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_date_id',
        'amount',
        'paid_at',
    ];

}
