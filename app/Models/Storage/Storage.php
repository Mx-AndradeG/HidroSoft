<?php

namespace App\Models\Storage;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StorageRelationships;
    use StorageAccessors;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'storages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'branch_id',
        'main'
    ];
}
