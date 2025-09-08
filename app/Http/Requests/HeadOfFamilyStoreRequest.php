<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyStoreRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'email' => ['required','string','email','max:255','unique:users'],
            'password' => ['required','string','min:8'],
            'profile_picture' => ['required','image','mimes:jpeg,png,jpg','max:1024'],
            'identity_number' => ['required','unique:head_of_families','numeric','digits:16'],
            'gender' => ['required','string','max:255','in:male,female'],
            'date_of_birth' => ['required','date'],
            'phone_number' => ['required','unique:head_of_families','string','max:255'],
            'occupation' => ['required','string','max:255'],
            'marital_status' => ['required','string','max:255','in:single,married'],
            'religion' => ['required','string','max:255','in:islam,christianity,hinduism,buddhism']
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'profile_picture' => 'Profile Picture',
            'identity_number' => 'Identity Number',
            'gender' => 'Gender',
            'date_of_birth' => 'Date of Birth',
            'phone_number' => 'Phone Number',
            'occupation' => 'Occupation',
            'marital_status' => 'Marital Status',
            'religion' => 'Religion'
        ];
    }
}
