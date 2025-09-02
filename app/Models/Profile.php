<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes, Uuid;

    public function profileImage(): BelongsTo
    {
        return $this->belongsTo(ProfileImage::class);
    }
}
