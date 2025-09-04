<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user)],
            'password' => ['nullable', 'string', 'min:8'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute is required',
            'string' => ':attribute must be a string',
            'max' => ':attribute must be at most :max characters',
            'min' => ':attribute must be at least :min characters',
            'unique' => ':attribute already exists',
            'email' => ':attribute must be a valid email address',
        ];
    }
}
