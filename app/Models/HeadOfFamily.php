<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfFamily extends Model
{
    use SoftDeletes, Uuid;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function socialAssistanceRecipients(): HasMany
    {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}
