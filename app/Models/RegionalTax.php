<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

class RegionalTax extends Model
{
    protected $table = 'wp_terms';

    public function newQuery(): Builder
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes())->regionalTax();
    }

    public function scopeRegionalTax(Builder $query): Builder
    {
        return $query
            ->selectRaw('wp_terms.name as city, coalesce(sum(backoffice_rental_information.regional_tax), 0) as regional_tax')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_id', '=', 'wp_terms.term_id')
            ->leftJoin('wp_term_relationships', 'wp_term_relationships.term_taxonomy_id', '=', 'wp_term_taxonomy.term_taxonomy_id')
            ->leftJoin('backoffice_commitments', 'backoffice_commitments.property_id', '=', 'wp_term_relationships.object_id')
            ->leftJoin('backoffice_rental_information', 'backoffice_rental_information.commitment_id', '=', 'backoffice_commitments.id')
            ->where('wp_term_taxonomy.taxonomy', 'property_city')
            ->orderBy('wp_terms.name')
            ->groupBy('wp_terms.name');
    }
}
