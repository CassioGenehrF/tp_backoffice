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
        $externalArea = self::getFeatureChildren('area-externa');
        $religiousActivities = self::getFeatureChildren('atividades-religiosas');
        $health = self::getFeatureChildren('bem-estar');
        $airConditioning = self::getFeatureChildren('climatizacao');
        $entertainment = self::getFeatureChildren('entretenimento-e-lazer');
        $events = self::getFeatureChildren('espaco-para-eventos');
        $parking = self::getFeatureChildren('estacionamento');
        $party = self::getFeatureChildren('festa-evento');
        $young = self::getFeatureChildren('grupo-de-jovens');
        $internet = self::getFeatureChildren('internet-e-escritorio');
        $location = self::getFeatureChildren('localizacao');
        $hookah = self::getFeatureChildren('narguile');
        $pets = self::getFeatureChildren('pet-animais-de-estimacao');
        $pool = self::getFeatureChildren('piscinas');
        $popular = self::getFeatureChildren('popular');
        $sustainable = self::getFeatureChildren('praticas-sustentaveis');
        $room = self::getFeatureChildren('quarto-e-lavanderia');
        $security = self::getFeatureChildren('seguranca-domestica');
        $service = self::getFeatureChildren('servicos');
        $loudSound = self::getFeatureChildren('som-alto');
        $carSound = self::getFeatureChildren('som-automotivo');

        $filters[array_keys($externalArea)[0]] = array_values($externalArea)[0];
        $filters[array_keys($religiousActivities)[0]] = array_values($religiousActivities)[0];
        $filters[array_keys($health)[0]] = array_values($health)[0];
        $filters[array_keys($airConditioning)[0]] = array_values($airConditioning)[0];
        $filters[array_keys($entertainment)[0]] = array_values($entertainment)[0];
        $filters[array_keys($events)[0]] = array_values($events)[0];
        $filters[array_keys($parking)[0]] = array_values($parking)[0];
        $filters[array_keys($party)[0]] = array_values($party)[0];
        $filters[array_keys($young)[0]] = array_values($young)[0];
        $filters[array_keys($internet)[0]] = array_values($internet)[0];
        $filters[array_keys($location)[0]] = array_values($location)[0];
        $filters[array_keys($hookah)[0]] = array_values($hookah)[0];
        $filters[array_keys($pets)[0]] = array_values($pets)[0];
        $filters[array_keys($pool)[0]] = array_values($pool)[0];
        $filters[array_keys($popular)[0]] = array_values($popular)[0];
        $filters[array_keys($sustainable)[0]] = array_values($sustainable)[0];
        $filters[array_keys($room)[0]] = array_values($room)[0];
        $filters[array_keys($security)[0]] = array_values($security)[0];
        $filters[array_keys($service)[0]] = array_values($service)[0];
        $filters[array_keys($loudSound)[0]] = array_values($loudSound)[0];
        $filters[array_keys($carSound)[0]] = array_values($carSound)[0];

        return $filters;
    }

    public function scopeGetFeature(Builder $query, $featureName): self
    {
        return $query->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_terms.slug', $featureName)
            ->first();
    }

    public function scopeGetFeatureChildren(Builder $query, $featureName): array
    {
        $parent = $this->getFeature($featureName);

        $children = $query->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
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
