<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

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

    public function scopeFilteredProperties(Builder $query, $terms): array
    {
        $filteredProperties = DB::table('wp_term_relationships')
            ->select(
                'object_id',
                DB::raw('group_concat(term_taxonomy_id) as terms')
            )
            ->groupBy('object_id');

        foreach ($terms as $filter) {
            $filteredProperties->having('terms', 'like', "%$filter%");
        }

        $filteredProperties = $filteredProperties->get()->map(function ($value) {
            return $value->object_id;
        })->all();

        return $filteredProperties;
    }

    public function scopePropertyFeature(Builder $query): Builder
    {
        return $query->where('taxonomy', 'property_features');
    }

    public function scopeExternalArea(Builder $query): self
    {
        return $query->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_terms.slug', 'area-externa')
            ->first();
    }

    public function scopeExternalAreaChildren(Builder $query): array
    {
        $externalAreaParent = $this->externalArea();

        $externalArea = $query->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', $externalAreaParent->term_id)
            ->orderBy('wp_terms.name')
            ->get();

        $data = $externalArea->map(function ($value) {
            return [
                'term_id' => $value->term_id,
                'name' => $value->name,
                'slug' => str_replace('-', '_', $value->slug)
            ];
        })->all();

        $response[$externalAreaParent->name] = $data;

        return $response;
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
