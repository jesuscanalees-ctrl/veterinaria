<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'rol' => 'required|in:administrador,veterinario',
            'especialidad' => 'exclude_unless:rol,veterinario|required_if:rol,veterinario|string|max:255',
            'cedula_profesional' => 'exclude_unless:rol,veterinario|required_if:rol,veterinario|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser texto.',
            'max' => 'El campo :attribute no debe ser mayor a :max caracteres.',
            'email' => 'El campo :attribute debe ser una dirección de correo válida.',
            'unique' => 'El :attribute ya está registrado.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'in' => 'El :attribute seleccionado es inválido.',
            'required_if' => 'El campo :attribute es obligatorio cuando el rol es veterinario.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'rol' => 'rol',
            'especialidad' => 'especialidad',
            'cedula_profesional' => 'cédula profesional',
        ];
    }
}
