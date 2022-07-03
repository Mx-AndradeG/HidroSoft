<?php

namespace App\Http\Requests\InventoryMovement;

use App\Rules\ValidateNameCustomerRule;
use App\Rules\ValidatePhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryMovementRequest extends FormRequest
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
            'inventory_movement_type_id'   =>  'required|numeric|min:1|exists:inventory_movement_types,id',
            'entry_movements'              => 'required|array|min:1',
        ];
    }
}
