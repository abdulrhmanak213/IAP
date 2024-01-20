<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileLog extends Model
{
    protected $fillable = [
        'user_id',
        'file_id',
        'operation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
