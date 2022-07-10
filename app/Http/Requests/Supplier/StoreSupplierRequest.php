<?php

namespace App\Http\Requests\Supplier;

use App\Rules\ValidateNameCustomerRule;
use App\Rules\ValidatePhoneRule;
use App\Rules\ValidateRfcRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSupplierRequest extends FormRequest
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
            'company_name'  => ['required', 'string', 'min:3', 'max:255'],
            'address'       => 'nullable|string|min:3|max:255',
            'phone'         => ['required', new ValidatePhoneRule()],
            'latitude'      => 'nullable',
            'longitude'     => 'nullable',
        ];
    }
}
