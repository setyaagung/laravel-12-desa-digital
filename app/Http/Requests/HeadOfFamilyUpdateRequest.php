<?php

namespace App\Http\Requests;

use App\Models\HeadOfFamily;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeadOfFamilyUpdateRequest extends FormRequest
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
        $headOfFamily = HeadOfFamily::find($this->head_of_family)->user_id;
        //$userId = $this->user;
        $headOfFamilyId = $this->head_of_family;

        //dd($headOfFamily, $headOfFamilyId);

        return [
            'name' => ['required','string','max:255'],
            'email' => ['required', 'string', 'email', 'max:255',
                    Rule::unique(User::class)->ignore($headOfFamily)],
            'password' => ['nullable','string','min:8'],
            'profile_picture' => ['nullable','image','mimes:jpeg,png,jpg','max:1024'],
            'identity_number' => ['required', 'numeric','numeric','digits:16',
                    Rule::unique(HeadOfFamily::class)->ignore($headOfFamilyId)],
            'gender' => ['required','string','max:255','in:male,female'],
            'date_of_birth' => ['required','date'],
            'phone_number' => ['required','string','max:255',
                    Rule::unique(HeadOfFamily::class)->ignore($headOfFamilyId)],
            'occupation' => ['required','string','max:255'],
            'marital_status' => ['required','string','max:255','in:single,married']
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
            'marital_status' => 'Marital Status'
        ];
    }
}
