<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PropertyFeature extends Model
{
    protected $table = 'wp_term_taxonomy';

    protected $fillable = [
        'term_taxonomy_id',
        'term_id',
        'taxonomy',
        'description',
        'parent',
        'count'
    ];

    public $timestamps = false;

    public function newQuery(): Builder
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes())->propertyFeature();
    }

    public function scopePropertyFeature(Builder $query): Builder
    {
        return $query->where('taxonomy', 'property_features');
    }

    public function scopeExternalArea(Builder $query): Builder
    {
        return $query->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_terms.slug', 'area-externa');
    }

    public function scopeExternalAreaChildren(Builder $query): Collection
    {
        $externalAreaId = $this->externalArea()->first()->term_id;

        return $query->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', $externalAreaId)
            ->orderBy('wp_terms.name')
            ->get();
    }

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'ID', 'user_indication_id');
    }
}
