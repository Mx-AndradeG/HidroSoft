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
        Validator::make($input['user'], [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string'],
        ])->validate();

        $company = new Company();
        $company->name = $input['company']['name'];
        $company->email = $input['company']['email'];
        $company->phone = $input['company']['phone'];
        $company->save();

        return User::create([
            'name' => $input['user']['name'],
            'email' => $input['user']['email'],
            'company_id' => $company->id,
            'password' => Hash::make($input['user']['password']),
        ]);
    }
}
