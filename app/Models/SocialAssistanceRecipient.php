<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistanceRecipient extends Model
{
    use SoftDeletes, Uuid;

    public function socialAssistance(): BelongsTo
    {
        return $this->belongsTo(SocialAssistance::class);
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
