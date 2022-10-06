<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

class Property extends Model
{
    protected $table = 'wp_posts';

    protected $primaryKey = 'ID';

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

    public function scopeStandard(Builder $query, $standard): Builder
    {
        if ($standard == 0) {
            return $query;
        }

        return $query->whereHas('propertyInfo', function ($query) use ($standard) {
            $query->where('standard', $standard);
        });
    }

    public function scopePeopleOrPackage(Builder $query, $minValue, $maxValue, $people, $daily, $period): Builder
    {
        $maxValue = intval($maxValue);
        $minValue = intval($minValue);
        $people = intval($people);
        $daily = intval($daily);

        if ($people == 0 && $minValue == 0 && $maxValue == 0 && $daily == 0) {
            return $query;
        }

        $query->whereHas('propertyValue', function ($query) use ($minValue, $maxValue, $daily, $people, $period) {
            if ($period != 0) {
                $query->where('billing_type', 'people');

                if ($people > 0) {
                    $query->where("min_people_$period", "<=", $people);
                    $query->where("max_people_$period", ">=", $people);

                    if ($minValue > 0) {
                        $value = $minValue / $people;
                        if ($period == 'carnival' || $period == 'christmas' || $period == 'new_year') {
                            $value = $minValue;
                        }
                        $query->where("price_per_people_$period", ">=", $value);
                    }

                    if ($maxValue > 0) {
                        $value = $maxValue / $people;
                        if ($period == 'carnival' || $period == 'christmas' || $period == 'new_year') {
                            $value = $maxValue;
                        }
                        $query->where("price_per_people_$period", "<=", $value);
                    }
                }

                if ($daily > 0) {
                    $query->where("min_daily_$period", "<=", $daily);
                }
            } else {
                $query->where('billing_type', 'people');
                $query->where(function ($query) use ($minValue, $maxValue, $people, $daily) {
                    $query->orWhere(function ($query) use ($minValue, $maxValue, $people, $daily) {
                        if ($people > 0) {
                            $query->where("min_people_weekend", "<=", $people);
                            $query->where("max_people_weekend", ">=", $people);

                            if ($minValue > 0) {
                                $query->where("price_per_people_weekend", ">=", $minValue / $people);
                            }

                            if ($maxValue > 0) {
                                $query->where("price_per_people_weekend", "<=", $maxValue / $people);
                            }
                        }

                        if ($daily > 0) {
                            $query->where("min_daily_weekend", "<=", $daily);
                        }
                    });

                    $query->orWhere(function ($query) use ($minValue, $maxValue, $people, $daily) {
                        if ($people > 0) {
                            $query->where("min_people_week", "<=", $people);
                            $query->where("max_people_week", ">=", $people);

                            if ($minValue > 0) {
                                $query->where("price_per_people_week", ">=", $minValue / $people);
                            }

                            if ($maxValue > 0) {
                                $query->where("price_per_people_week", "<=", $maxValue / $people);
                            }
                        }

                        if ($daily > 0) {
                            $query->where("min_daily_week", "<=", $daily);
                        }
                    });

                    $query->orWhere(function ($query) use ($minValue, $maxValue, $people, $daily) {
                        if ($people > 0) {
                            $query->where("min_people_holiday", "<=", $people);
                            $query->where("max_people_holiday", ">=", $people);

                            if ($minValue > 0) {
                                $query->where("price_per_people_holiday", ">=", $minValue / $people);
                            }

                            if ($maxValue > 0) {
                                $query->where("price_per_people_holiday", "<=", $maxValue / $people);
                            }
                        }

                        if ($daily > 0) {
                            $query->where("min_daily_holiday", "<=", $daily);
                        }
                    });

                    $query->orWhere(function ($query) use ($minValue, $maxValue, $people, $daily) {
                        if ($people > 0) {
                            $query->where("min_people_christmas", "<=", $people);
                            $query->where("max_people_christmas", ">=", $people);

                            if ($minValue > 0) {
                                $query->where("price_per_people_christmas", ">=", $minValue);
                            }

                            if ($maxValue > 0) {
                                $query->where("price_per_people_christmas", "<=", $maxValue);
                            }
                        }

                        if ($daily > 0) {
                            $query->where("min_daily_christmas", "<=", $daily);
                        }
                    });

                    $query->orWhere(function ($query) use ($minValue, $maxValue, $people, $daily) {
                        if ($people > 0) {
                            $query->where("min_people_new_year", "<=", $people);
                            $query->where("max_people_new_year", ">=", $people);

                            if ($minValue > 0) {
                                $query->where("price_per_people_new_year", ">=", $minValue);
                            }

                            if ($maxValue > 0) {
                                $query->where("price_per_people_new_year", "<=", $maxValue);
                            }
                        }

                        if ($daily > 0) {
                            $query->where("min_daily_new_year", "<=", $daily);
                        }
                    });

                    $query->orWhere(function ($query) use ($minValue, $maxValue, $people, $daily) {
                        if ($people > 0) {
                            $query->where("min_people_carnival", "<=", $people);
                            $query->where("max_people_carnival", ">=", $people);

                            if ($minValue > 0) {
                                $query->where("price_per_people_carnival", ">=", $minValue);
                            }

                            if ($maxValue > 0) {
                                $query->where("price_per_people_carnival", "<=", $maxValue);
                            }
                        }

                        if ($daily > 0) {
                            $query->where("min_daily_carnival", "<=", $daily);
                        }
                    });
                });
            }
        });

        return $query->orWhereHas('propertyValue', function ($query) use ($minValue, $maxValue, $people) {
            $query->where('billing_type', 'package');

            $query->where(function ($query) use ($minValue, $maxValue, $people) {
                $query->orWhere(function ($query) use ($minValue, $maxValue, $people) {
                    if ($minValue != 0) {
                        $query->where("price_package_start", ">=", $minValue);
                    }

                    if ($maxValue != 0) {
                        $query->where("price_package_start", "<=", $maxValue);
                    }

                    if ($people != 0) {
                        $query->where('max_people_package_start', ">=", $people);
                    }
                });

                $query->orWhere(function ($query) use ($minValue, $maxValue, $people) {
                    if ($minValue != 0) {
                        $query->where("price_package_2", ">=", $minValue);
                    }

                    if ($maxValue != 0) {
                        $query->where("price_package_2", "<=", $maxValue);
                    }

                    if ($people != 0) {
                        $query->where('min_people_package_2', "<=", $people);
                        $query->where('max_people_package_2', ">=", $people);
                    }
                });

                $query->orWhere(function ($query) use ($minValue, $maxValue, $people) {
                    if ($minValue != 0) {
                        $query->where("price_package_3", ">=", $minValue);
                    }

                    if ($maxValue != 0) {
                        $query->where("price_package_3", "<=", $maxValue);
                    }

                    if ($people != 0) {
                        $query->where('min_people_package_3', "<=", $people);
                        $query->where('max_people_package_3', ">=", $people);
                    }
                });

                $query->orWhere(function ($query) use ($minValue, $maxValue, $people) {
                    if ($minValue != 0) {
                        $query->where("price_package_4", ">=", $minValue);
                    }

                    if ($maxValue != 0) {
                        $query->where("price_package_4", "<=", $maxValue);
                    }

                    if ($people != 0) {
                        $query->where('min_people_package_4', "<=", $people);
                        $query->where('max_people_package_4', ">=", $people);
                    }
                });

                $query->orWhere(function ($query) use ($minValue, $maxValue, $people) {
                    if ($minValue != 0) {
                        $query->where("price_package_5", ">=", $minValue);
                    }

                    if ($maxValue != 0) {
                        $query->where("price_package_5", "<=", $maxValue);
                    }

                    if ($people != 0) {
                        $query->where('min_people_package_5', "<=", $people);
                        $query->where('max_people_package_5', ">=", $people);
                    }
                });
            });
        });
    }

    public function scopeHighStandard(Builder $query): Builder
    {
        return $query->inRandomOrder()
            ->published()
            ->standard(3)
            ->select('ID');
    }

    public function scopeMediumStandard(Builder $query): Builder
    {
        return $query->inRandomOrder()
            ->published()
            ->standard(2)
            ->select('ID');
    }

    public function scopeLowStandard(Builder $query): Builder
    {
        return $query->inRandomOrder()
            ->published()
            ->standard(1)
            ->select('ID');
    }

    public function scopeProperty(Builder $query): Builder
    {
        return $query->where('post_type', 'estate_property');
    }

    public static function export(): Collection
    {
        $properties = new Collection([
            'low' => self::lowStandard()->get(),
            'medium' => self::mediumStandard()->get(),
            'high' => self::highStandard()->get()
        ]);

        $properties['low'] = $properties['low']->map(function ($property) {
            return $property->ID;
        })->all();

        $properties['medium'] = $properties['medium']->map(function ($property) {
            return $property->ID;
        })->all();

        $properties['high'] = $properties['high']->map(function ($property) {
            return $property->ID;
        })->all();

        return $properties;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'post_author', 'ID');
    }

    public function propertyInfo(): HasOne
    {
        return $this->hasOne(PropertyInfo::class, 'property_id', 'ID');
    }

    public function propertyValue(): hasOne
    {
        return $this->hasOne(PropertyValue::class, 'property_id', 'ID');
    }

    public function verified(): HasOne
    {
        return $this->hasOne(VerifiedProperty::class, 'property_id', 'ID');
    }
}
