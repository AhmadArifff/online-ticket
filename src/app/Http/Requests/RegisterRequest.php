<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required_without:first_name|string|max:255',
            'first_name' => 'required_without:name|string|max:255',
            'last_name' => 'required_without:name|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:15',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required_without' => 'Nama lengkap atau nama depan diperlukan',
            'first_name.required_without' => 'Nama depan diperlukan jika nama lengkap tidak diisi',
            'last_name.required_without' => 'Nama belakang diperlukan jika nama lengkap tidak diisi',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'email.unique' => 'Email already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Passwords do not match',
        ];
    }
}
