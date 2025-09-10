<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantUpdateRequest extends FormRequest
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
            'event_id' => ['required', 'exists:events,id'],
            'head_of_family_id' => ['required', 'exists:head_of_families,id'],
            'quantity' => ['required', 'numeric'],
            'total_price' => ['required', 'numeric'],
            'payment_status' => ['required', 'string', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Head of Family',
            'quantity' => 'Quantity',
            'total_price' => 'Total Price',
            'payment_status' => 'Payment Status',
        ];
    }
}
