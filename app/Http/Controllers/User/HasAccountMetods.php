<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateAccountDataRequest;
use App\Models\User;

trait HasAccountMetods
{
    public function updateAccountData(UpdateAccountDataRequest $request, User $user)
    {
        $user->fill($request->validated()['account_data']);
        $user->save();
        return $user;
    }

    public function changeAccountPassword()
    {

    }

    public function getAccountActivity()
    {

    }
}
