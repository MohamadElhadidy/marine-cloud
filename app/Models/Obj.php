<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use App\Models\Traits\RelatesToTeams;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Obj extends Model
{
    use RelatesToTeams, HasRecursiveRelationships, Searchable;

    protected $table = 'objects';

    public $asYouType = true;

    protected $fillable = [
        'parent_id'
    ];

    public static function booted(): void
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });

        static::deleting(function ($model) {
            optional($model->objectable)->delete();
            $model->descendants->each->delete();
        });
    }

    public function objectable(): MorphTo
    {
        return $this->morphTo();
    }
}
