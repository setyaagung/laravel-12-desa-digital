<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use SoftDeletes, Uuid;

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
