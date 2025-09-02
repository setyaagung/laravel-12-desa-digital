<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, Uuid;

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }
}
