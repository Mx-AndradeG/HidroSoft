<?php

namespace App\Models\Notifications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;
    use NotificationRelationships;
    use NotificationAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'storage_id',
        'product_id',
        'menssage',
        'viewed',
    ];
}
