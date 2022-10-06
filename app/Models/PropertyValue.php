<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PropertyValue extends Model
{
    protected $table = 'property_value';

    protected $fillable = [
        'property_id',
        'billing_type',
        'min_people_weekend',
        'max_people_weekend',
        'min_daily_weekend',
        'price_per_people_weekend',
        'checkin_hour_weekend',
        'checkout_hour_weekend',
        'min_people_day_use',
        'max_people_day_use',
        'price_per_people_day_use',
        'checkin_hour_day_use',
        'checkout_hour_day_use',
        'min_people_week',
        'max_people_week',
        'min_daily_week',
        'price_per_people_week',
        'checkin_hour_week',
        'checkout_hour_week',
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'min_people_holiday',
        'max_people_holiday',
        'min_daily_holiday',
        'price_per_people_holiday',
        'checkin_hour_holiday',
        'checkout_hour_holiday',
        'min_people_christmas',
        'max_people_christmas',
        'min_daily_christmas',
        'price_per_people_christmas',
        'checkin_hour_christmas',
        'checkout_hour_christmas',
        'min_people_new_year',
        'max_people_new_year',
        'min_daily_new_year',
        'price_per_people_new_year',
        'checkin_hour_new_year',
        'checkout_hour_new_year',
        'min_people_carnival',
        'max_people_carnival',
        'min_daily_carnival',
        'price_per_people_carnival',
        'checkin_hour_carnival',
        'checkout_hour_carnival',
        'max_people_package_start',
        'price_package_start',
        'min_people_package_2',
        'max_people_package_2',
        'price_package_2',
        'min_people_package_3',
        'max_people_package_3',
        'price_package_3',
        'min_people_package_4',
        'max_people_package_4',
        'price_package_4',
        'min_people_package_5',
        'max_people_package_5',
        'price_package_5'
    ];

    public function property(): HasOne
    {
        return $this->hasOne(Property::class, 'ID', 'property_id');
    }

    public function scopePackage(Builder $query): Builder
    {
        return $query
            ->where('id', '=', $this->id)
            ->where('billing_type', '=', 'package')
            ->select(
                'property_id',
                'billing_type',
                'max_people_package_start',
                'price_package_start',
                'min_people_package_2',
                'max_people_package_2',
                'price_package_2',
                'min_people_package_3',
                'max_people_package_3',
                'price_package_3',
                'min_people_package_4',
                'max_people_package_4',
                'price_package_4',
                'min_people_package_5',
                'max_people_package_5',
                'price_package_5'
            );
    }

    public function scopePeople(Builder $query): Builder
    {
        return $query
            ->where('id', '=', $this->id)
            ->where('billing_type', '=', 'people')
            ->select(
                'property_id',
                'billing_type',
                'min_people_weekend',
                'max_people_weekend',
                'min_daily_weekend',
                'price_per_people_weekend',
                'checkin_hour_weekend',
                'checkout_hour_weekend',
                'min_people_day_use',
                'max_people_day_use',
                'price_per_people_day_use',
                'checkin_hour_day_use',
                'checkout_hour_day_use',
                'min_people_week',
                'max_people_week',
                'min_daily_week',
                'price_per_people_week',
                'checkin_hour_week',
                'checkout_hour_week',
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'min_people_holiday',
                'max_people_holiday',
                'min_daily_holiday',
                'price_per_people_holiday',
                'checkin_hour_holiday',
                'checkout_hour_holiday',
                'min_people_christmas',
                'max_people_christmas',
                'min_daily_christmas',
                'price_per_people_christmas',
                'checkin_hour_christmas',
                'checkout_hour_christmas',
                'min_people_new_year',
                'max_people_new_year',
                'min_daily_new_year',
                'price_per_people_new_year',
                'checkin_hour_new_year',
                'checkout_hour_new_year',
                'min_people_carnival',
                'max_people_carnival',
                'min_daily_carnival',
                'price_per_people_carnival',
                'checkin_hour_carnival',
                'checkout_hour_carnival',
            );
    }
}
