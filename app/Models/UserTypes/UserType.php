<?php

namespace App\Models\UserTypes;

use App\Models\Users\UserRelationships;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserType extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use UserTypeRelationships;

    public CONST ADMIN = '1';
    public CONST EMPLOYEE = '2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

}
