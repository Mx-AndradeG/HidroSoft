<?php

namespace App\Http\Requests\User;

use App\Rules\ValidateNameCustomerRule;
use App\Rules\ValidatePhoneRule;
use App\Rules\ValidateRfcRule;
use Illuminate\Foundation\Http\FormRequest;

class ValidateSecondStepRequest extends FormRequest
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
            'name'      => 'required|string|min:3|max:255',
            'phone'     => ['required', new ValidatePhoneRule()],
            'email'     => 'required|unique:companies,email',
        ];
    }
}
