<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use SoftDeletes, Uuid, HasFactory;

    public function scopeSearch($query, $search)
    {
        return $query->whereHas('headOfFamily', function ($query) use ($search) {
            $query->whereHas('user', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
            });
        })->orWhereHas('event', function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        });
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
