<?php

namespace App\Models\Users;

use App\Models\UserTypes\UserType;

trait UserRelationships
{
    public function user_type(){
        return $this->belongsTo(UserType::class);
    }

}
