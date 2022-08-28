<?php

namespace App\Models\Users;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\UserTypes\UserType;

trait UserRelationships
{
    public function user_type(){
        return $this->belongsTo(UserType::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class);
    }

    public function company(){
        return $this->belongsTo(Company::class);
    }

}
