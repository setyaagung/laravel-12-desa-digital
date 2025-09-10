<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUpdateRequest extends FormRequest
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
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'is_available' => ['required', 'boolean']
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Name',
            'description' => 'Description',
            'date' => 'Date',
            'time' => 'Time',
            'price' => 'Price',
            'is_available' => 'Is Available'
        ];
    }
}
