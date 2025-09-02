<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use SoftDeletes, Uuid;

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
