<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        return $this->belongsTo(User::class, 'ID', 'post_author');
    }

    public function propertyInfo(): HasOne
    {
        return $this->hasOne(PropertyInfo::class, 'property_id', 'ID');
    }
}
