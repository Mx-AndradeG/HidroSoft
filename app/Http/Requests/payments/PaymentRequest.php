<?php

namespace App\Http\Requests\payments;


use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sale_id'   => 'required|numeric|exists:sales,id',
            'amount'    => 'required|numeric|',
            'payment_method_id' => 'required|numeric|exists:payment_methods,id',
            'received_amount'   => ['required_if:payment_method_id,1|numeric|min:1'],
            'reference_code'    => ['required_if:payment_method_id,2|string|min:3|max:255'],
        ];
    }
}
