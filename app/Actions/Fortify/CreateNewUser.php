<?php

namespace App\Actions\Fortify;

use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Storage\Storage;
use App\Models\User;
use App\Models\UserTypes\UserType;
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

        $branch = new Branch();
        $branch->name = 'Sucursar principal de: '. $input['company']['name'];
        $branch->email = $input['company']['email'];
        $branch->phone = $input['company']['phone'];
        $branch->company_id = $company->id;
        $branch->main = 1;
        $branch->save();

        
        $storage = new Storage();
        $storage->name = 'Almacen principal de: ' . $input['company']['name'];
        $storage->branch_id = $branch->id;
        $storage->main = 1;
        $storage->save();
        
        
        $user = new User();
        $user->name = $input['user']['name'];
        $user->email = $input['user']['email'];
        $user->company_id = $company->id;
        $user->user_type_id = UserType::ADMIN;
        $user->password = Hash::make($input['user']['password']);
        $user->save();
        
        return $user;
    }
}
