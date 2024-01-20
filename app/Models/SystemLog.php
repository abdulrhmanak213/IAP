<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'verb',
        'request_body',
        'route',
        'response_code',
        'response_body',
        'user_id',
    ];
}
