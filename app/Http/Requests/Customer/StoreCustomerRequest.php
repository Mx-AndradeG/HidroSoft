<?php

namespace App\Http\Requests\Customer;

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
            'name'          => 'required|string|min:3|max:255|regex:/^[a-zA-ZÑñ\s]+$/',
            'address'          => 'required|string|min:3|max:255',
            'phone'          => 'required|regex:/^[-0-9\+]+$/',
            'rfc'          => 'required|regex:/^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})',
            'email'          => 'required|email',
            'social'          => 'required|string|min:3|max:255',
        ];
    }
}
