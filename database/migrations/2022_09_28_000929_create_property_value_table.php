<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_value', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('billing_type');

            $table->integer('min_people_weekend')->nullable();
            $table->integer('max_people_weekend')->nullable();
            $table->integer('min_daily_weekend')->nullable();
            $table->decimal('price_per_people_weekend')->nullable();
            $table->time('checkin_hour_weekend')->nullable();
            $table->time('checkout_hour_weekend')->nullable();

            $table->integer('min_people_day_use')->nullable();
            $table->integer('max_people_day_use')->nullable();
            $table->decimal('price_per_people_day_use')->nullable();
            $table->time('checkin_hour_day_use')->nullable();
            $table->time('checkout_hour_day_use')->nullable();

            $table->integer('min_people_week')->nullable();
            $table->integer('max_people_week')->nullable();
            $table->integer('min_daily_week')->nullable();
            $table->decimal('price_per_people_week')->nullable();
            $table->time('checkin_hour_week')->nullable();
            $table->time('checkout_hour_week')->nullable();
            $table->boolean('monday')->nullable();
            $table->boolean('tuesday')->nullable();
            $table->boolean('wednesday')->nullable();
            $table->boolean('thursday')->nullable();
            $table->boolean('friday')->nullable();

            $table->integer('min_people_holiday')->nullable();
            $table->integer('max_people_holiday')->nullable();
            $table->integer('min_daily_holiday')->nullable();
            $table->decimal('price_per_people_holiday')->nullable();
            $table->time('checkin_hour_holiday')->nullable();
            $table->time('checkout_hour_holiday')->nullable();

            $table->integer('min_people_christmas')->nullable();
            $table->integer('max_people_christmas')->nullable();
            $table->integer('min_daily_christmas')->nullable();
            $table->decimal('price_per_people_christmas')->nullable();
            $table->time('checkin_hour_christmas')->nullable();
            $table->time('checkout_hour_christmas')->nullable();

            $table->integer('min_people_new_year')->nullable();
            $table->integer('max_people_new_year')->nullable();
            $table->integer('min_daily_new_year')->nullable();
            $table->decimal('price_per_people_new_year')->nullable();
            $table->time('checkin_hour_new_year')->nullable();
            $table->time('checkout_hour_new_year')->nullable();

            $table->integer('min_people_carnival')->nullable();
            $table->integer('max_people_carnival')->nullable();
            $table->integer('min_daily_carnival')->nullable();
            $table->decimal('price_per_people_carnival')->nullable();
            $table->time('checkin_hour_carnival')->nullable();
            $table->time('checkout_hour_carnival')->nullable();

            $table->integer('max_people_package_start')->nullable();
            $table->decimal('price_package_start')->nullable();
            $table->integer('min_people_package_2')->nullable();
            $table->integer('max_people_package_2')->nullable();
            $table->decimal('price_package_2')->nullable();
            $table->integer('min_people_package_3')->nullable();
            $table->integer('max_people_package_3')->nullable();
            $table->decimal('price_package_3')->nullable();
            $table->integer('min_people_package_4')->nullable();
            $table->integer('max_people_package_4')->nullable();
            $table->decimal('price_package_4')->nullable();
            $table->integer('min_people_package_5')->nullable();
            $table->integer('max_people_package_5')->nullable();
            $table->decimal('price_package_5')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_value');
    }
}
