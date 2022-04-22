<?php

namespace App\Actions\Fortify;

use App\Models\Company\Company;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $company = new Company();
        $company->name = $input['company']['name'];
        $company->email = $input['company']['email'];
        $company->phone = $input['company']['phone'];
        $company->save();
        
        $user = new User();
        $user->name = $input['user']['name'];
        $user->email = $input['user']['email'];
        $user->company_id = $company->id;
        $user->password = Hash::make($input['user']['password']);
        $user->save();
        
        return $user;
    }
}
