<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Models\Traits\RelatesToTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Obj extends Model
{
    use RelatesToTeams, HasRecursiveRelationships;

    protected $table = 'objects';

    protected $fillable = [
        'parent_id'
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    public function objectable(): MorphTo
    {
        return $this->morphTo();
    }
}
