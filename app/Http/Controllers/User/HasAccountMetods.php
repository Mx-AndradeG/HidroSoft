<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\UpdateAccountDataRequest;
use App\Http\Requests\User\UpdateAccountPasswordRequest;
use Illuminate\Support\Facades\Hash;

trait HasAccountMetods
{
    public function updateAccountData(UpdateAccountDataRequest $request)
    {
        auth()->user()->fill($request->validated()['account_data']);
        auth()->user()->save();
        return auth()->user();
    }

    public function updateAccountPassword(UpdateAccountPasswordRequest $request)
    {
        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);
        return auth()->user();
    }

    public function getAccountActivity()
    {

    }
}
