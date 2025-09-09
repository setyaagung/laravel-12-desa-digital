<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAssistanceRecipientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'head_of_family' => new HeadOfFamilyResource($this->headOfFamily),
            'social_assistance' => new SocialAssistanceResource($this->socialAssistance),
            'bank' => $this->bank,
            'account_number' => $this->account_number,
            'reason' => $this->reason,
            'proof' => $this->proof,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
