<?php

namespace App\Http\Requests\Storage;

use App\Rules\ValidatePhoneRule;
use App\Rules\ValidateRfcRule;
use Illuminate\Foundation\Http\FormRequest;

class StorageBranchRequest extends FormRequest
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
            'name'      => ['required', 'string', 'min:3', 'max:255'],
            'address'   => 'required|string|min:3|max:255',
            'latitude'  => 'required',
            'longitude' => 'required',
            'branch_id' => 'required|numeric|min:1|exists:branches,id',
        ];
    }
}
