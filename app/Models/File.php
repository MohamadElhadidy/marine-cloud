<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'name',
        'size',
        'path'
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
