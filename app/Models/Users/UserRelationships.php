<?php

namespace App\Models\Users;

use App\Models\Company\Company;

trait UserRelationships
{
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
