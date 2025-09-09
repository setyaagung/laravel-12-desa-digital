<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistanceRecipient extends Model
{
    use SoftDeletes, Uuid, HasFactory;

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('socialAssistance', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('category', 'like', '%' . $search . '%')
            ->orWhere('provider', 'like', '%' . $search . '%');
        })
        ->orWhereHas('headOfFamily', function ($query) use ($search) {
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            })->orWhere('identity_number', 'like', '%' . $search . '%');
        });
    }

    public function socialAssistance(): BelongsTo
    {
        return $this->belongsTo(SocialAssistance::class);
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
