<?php

namespace App\Http\Requests\Sale;

use App\Rules\ValidateNameCustomerRule;
use App\Rules\ValidatePhoneRule;
use App\Rules\ValidateRfcRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'sale_type_id'      => 'required|exists:sale_types,id',
            'current_produts'   => ['required', 'array', 'min:1'],
            'client_id'         => 'required',
            'total_sale'        => ['required', 'numeric', 'min:1'],
            'payment_method_id' => 'required|numeric|exists:payment_methods,id',
            'received_amount'   => ['required_if:payment_method_id,1|numeric|min:1'],
            'reference_code'    => ['required_if:payment_method_id,2|string|min:3|max:255'],
            'deadline_id'       => ['required_if:sale_type_id,2|numeric'],
            'payment_plan_id'   => ['required_if:sale_type_id,2|numeric'],

        ];
    }
}
