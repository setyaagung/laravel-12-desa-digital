<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use SoftDeletes, Uuid;

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%$search%")
        ->orWhere('category', 'like', "%$search%")
        ->orWhere('provider', 'like', "%$search%");
    }

    public function socialAssistanceRecipients(): HasMany
    {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }
}
