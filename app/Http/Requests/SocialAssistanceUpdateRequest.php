<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceUpdateRequest extends FormRequest
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'provider' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_available' => 'required|boolean'
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Name',
            'category' => 'Category',
            'amount' => 'Amount',
            'provider' => 'Provider',
            'description' => 'Description',
            'is_available' => 'Is Available'
        ];
    }
}
