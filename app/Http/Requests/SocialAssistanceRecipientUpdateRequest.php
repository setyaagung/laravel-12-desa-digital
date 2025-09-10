<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceRecipientUpdateRequest extends FormRequest
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
            'social_assistance_id' => 'required|exists:social_assistances,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
            'reason' => 'nullable|string|max:255',
            'proof' => 'nullable|string|max:255',
            'is_available' => 'required|boolean',
        ];
    }

    public function attributes()
    {
        return [
            'social_assistance_id' => 'Social Assistance ID',
            'head_of_family_id' => 'Head of Family ID',
            'bank' => 'Bank',
            'account_number' => 'Account Number',
            'amount' => 'Amount',
            'reason' => 'Reason',
            'proof' => 'Proof',
            'is_available' => 'Is Available'
        ];
    }
}
