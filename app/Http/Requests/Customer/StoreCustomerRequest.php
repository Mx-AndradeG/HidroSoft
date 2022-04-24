<?php

namespace App\Http\Requests\Supplier;

use App\Rules\ValidateNameCustomerRule;
use App\Rules\ValidatePhoneRule;
use App\Rules\ValidateRfcRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'company_name'          => ['required', 'string', 'min:3', 'max:255', new ValidateNameCustomerRule()],
            'address'          => 'required|string|min:3|max:255',
            'phone'          => ['required', new ValidatePhoneRule()],
            'email'          => 'required|email',
            'social'          => 'string|min:3|max:255',
        ];
    }
}
