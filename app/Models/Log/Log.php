<?php

namespace App\Models\Log;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogRelationships;
    use LogAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'action',
        'module',
        'type',
        'user_id',
        'company_id',
    ];
}
