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

    public static function loadFilters(): array
    {
        $filters = [];
        $filters = self::getFeatureChildren('area-externa', $filters);
        $filters = self::getFeatureChildren('atividades-religiosas', $filters);
        $filters = self::getFeatureChildren('bem-estar', $filters);
        $filters = self::getFeatureChildren('climatizacao', $filters);
        $filters = self::getFeatureChildren('entretenimento-e-lazer', $filters);
        $filters = self::getFeatureChildren('espaco-para-eventos', $filters);
        $filters = self::getFeatureChildren('estacionamento', $filters);
        $filters = self::getFeatureChildren('festa-evento', $filters);
        $filters = self::getFeatureChildren('grupo-de-jovens', $filters);
        $filters = self::getFeatureChildren('internet-e-escritorio', $filters);
        $filters = self::getFeatureChildren('localizacao', $filters);
        $filters = self::getFeatureChildren('narguile', $filters);
        $filters = self::getFeatureChildren('pet-animais-de-estimacao', $filters);
        $filters = self::getFeatureChildren('piscinas', $filters);
        $filters = self::getFeatureChildren('popular', $filters);
        $filters = self::getFeatureChildren('praticas-sustentaveis', $filters);
        $filters = self::getFeatureChildren('quarto-e-lavanderia', $filters);
        $filters = self::getFeatureChildren('seguranca-domestica', $filters);
        $filters = self::getFeatureChildren('servicos', $filters);
        $filters = self::getFeatureChildren('regras-de-som', $filters);
        $filters = self::getFeatureChildren('som-automotivo', $filters);

        return $filters;
    }

    public static function getFeature($featureName)
    {
        return self::join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_terms.slug', $featureName)
            ->first();
    }

    public static function getFeatureChildren($featureName, $filters)
    {
        $parent = self::getFeature($featureName);

        if ($parent) {
            $children = self::join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
                ->where('wp_term_taxonomy.parent', $parent->term_id)
                ->orderBy('wp_terms.name')
                ->get();

            $data = $children->map(function ($value) {
                return [
                    'term_id' => $value->term_id,
                    'name' => $value->name,
                    'slug' => str_replace('-', '_', $value->slug)
                ];
            })->all();

            $response[$parent->name] = $data;

            $filters[array_keys($response)[0]] = array_values($response)[0];
        }

        return $filters;
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
