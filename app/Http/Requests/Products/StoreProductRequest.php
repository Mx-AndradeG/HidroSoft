<?php

namespace App\Http\Requests\Products;

use App\Rules\ValidateNameCustomerRule;
use App\Rules\ValidatePhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name'          => ['required', 'string', 'min:3', 'max:255'],
            'description'   => 'required|string|min:3|max:255',
            'code'          => 'required|string|min:3|max:255',
            'sale_price'    => 'required|numeric|min:1',
            'purchase_price'=> 'required|numeric|min:1',
            'category_id'   =>  'required|numeric|min:1|exists:categories,id',
            'supplier_id'   =>  'required|numeric|min:1|exists:suppliers,id',
        ];
    }
}
