<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'value',
    ];

    public function items(): MorphToMany
    {
        return $this->morphedByMany(Item::class, 'priced_thing');
    }

    public function scopeValueBetween(Builder $query, int $min, int $max): Builder
    {
        return $query->where(
            [
                ['value', '>=', $min],
                ['value', '<=', $max],
            ]
        );
    }
}
