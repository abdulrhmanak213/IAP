<?php

namespace App\Traits;

use App\Models\Notification;

trait HasNotification
{
    public function notifications(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Notification::class, 'userable')->orderBy('created_at','DESC');
    }
}
