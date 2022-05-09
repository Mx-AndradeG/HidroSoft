<?php

namespace App\Models\Categories;

use App\Models\Company\Company;

trait CategoryRelationships
{
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
