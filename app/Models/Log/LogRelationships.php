<?php

namespace App\Models\Log;

use App\Models\Company\Company;
use App\Models\User;

trait LogRelationships
{
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
