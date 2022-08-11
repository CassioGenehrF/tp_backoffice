<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Property extends Model
{
    protected $table = 'wp_posts';

    protected $fillable = [
        'ID',
        'post_author',
        'post_date',
        'post_date_gmt',
        'post_content',
        'post_title',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count'
    ];

    protected $appends = [
        'notes',
        'city',
        'state',
        'street',
        'externalArea',
        'kitchen',
        'entertainment',
        'internet',
        'popularItens',
        'location',
        'pool',
        'room',
        'sustainable'
    ];

    protected function getNotesAttribute(): string
    {
        $notes = DB::query()
            ->select('wp_postmeta.meta_value')
            ->from('wp_posts')
            ->join('wp_postmeta', 'wp_postmeta.post_id', '=', 'wp_posts.ID')
            ->where('wp_postmeta.meta_key', 'owner_notes')
            ->where('wp_posts.ID', $this->ID)
            ->first();

        $notes = $notes ? $notes->meta_value : '';
        return $notes;
    }

    protected function getCityAttribute(): string
    {
        $city = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'property_city')
            ->where('wp_posts.ID', $this->ID)
            ->first();

        $city = $city ? $city->name : '';
        return $city;
    }

    protected function getStateAttribute(): string
    {
        $state = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.taxonomy', 'property_county_state')
            ->where('wp_posts.ID', $this->ID)
            ->first();

        $state = $state ? $state->name : '';
        return $state;
    }

    protected function getStreetAttribute(): string
    {
        $street = DB::query()
            ->select('meta_value')
            ->from('wp_postmeta')
            ->where('post_id', $this->ID)
            ->where('meta_key', 'property_address')
            ->first();

        $street = $street ? $street->meta_value : '';
        return $street;
    }

    protected function getExternalAreaAttribute(): array
    {
        $externalArea = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 186)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $externalArea->all();
    }

    protected function getKitchenAttribute(): array
    {
        $kitchen = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 155)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $kitchen->all();
    }

    protected function getEntertainmentAttribute(): array
    {
        $externalArea = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 111)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $externalArea->all();
    }

    protected function getInternetAttribute(): array
    {
        $internet = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 149)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $internet->all();
    }

    protected function getPopularItensAttribute(): array
    {
        $popularItens = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 216)
            ->where('wp_posts.ID', $this->ID)
            ->get();
        return $popularItens->all();
    }

    protected function getLocationAttribute(): array
    {
        $location = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 178)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $location->all();
    }

    protected function getPoolAttribute(): array
    {
        $pool = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 199)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $pool->all();
    }

    protected function getRoomAttribute(): array
    {
        $room = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 100)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $room->all();
    }

    protected function getSustainableAttribute(): array
    {
        $room = DB::query()
            ->select('wp_terms.name')
            ->from('wp_posts')
            ->join('wp_term_relationships', 'wp_term_relationships.object_id', '=', 'wp_posts.ID')
            ->join('wp_term_taxonomy', 'wp_term_taxonomy.term_taxonomy_id', '=', 'wp_term_relationships.term_taxonomy_id')
            ->join('wp_terms', 'wp_terms.term_id', '=', 'wp_term_taxonomy.term_id')
            ->where('wp_term_taxonomy.parent', 292)
            ->where('wp_posts.ID', $this->ID)
            ->get();

        return $room->all();
    }

    public function newQuery(): Builder
    {
        return $this->registerGlobalScopes($this->newQueryWithoutScopes())->property()->active();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('post_status', '!=', 'trash');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('post_status', 'publish');
    }

    public function scopeProperty(Builder $query): Builder
    {
        return $query->where('post_type', 'estate_property');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'post_author', 'ID');
    }

    public function propertyInfo(): HasOne
    {
        return $this->hasOne(PropertyInfo::class, 'property_id', 'ID');
    }

    public function verified(): HasOne
    {
        return $this->hasOne(VerifiedProperty::class, 'property_id', 'ID');
    }
}
