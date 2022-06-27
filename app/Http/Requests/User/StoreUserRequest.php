<?php

namespace App\Http\Requests\User;

use App\Rules\ValidateNameCustomerRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => ['required', 'string', 'min:3', 'max:255', new ValidateNameCustomerRule()],
            'email'         => 'required|unique:users,email',
            'user_type_id'  => 'required|numeric|min:1|exists:user_types,id',
        ];
    }
}
