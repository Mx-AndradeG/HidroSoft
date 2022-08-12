<?php

namespace App\Models\Users;

use App\Models\UserTypes\UserType;
use Carbon\Carbon;

trait UserAccessors
{
    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function getFormattedUpdatedAtAttribute()
    {
        return Carbon::parse($this->updated_at)->format('Y-m-d');
    }

    public function getUserTypeNameAttribute()
    {
        return $this->user_type ? ($this->user_type_id == UserType::ADMIN ? 'Administrador' : 'Empleado') : 'No tiene';
    }
}
