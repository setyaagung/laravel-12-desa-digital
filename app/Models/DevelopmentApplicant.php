<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    use SoftDeletes, Uuid;

    public function development(): BelongsTo
    {
        return $this->belongsTo(Development::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
