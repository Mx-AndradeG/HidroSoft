<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateAccountPasswordRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'current_password' => 'required|string|current_password',
            'password' => ['required', 'string', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed'],
            'password_confirmation' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'password.confirmed' => 'El campo confirmar contraseña no coincide.',
            'current_password.required' => 'El campo contraseña actual es requerido.',
            'password.required' => 'El campo contraseña es requerido.',
        ];
    }
}
