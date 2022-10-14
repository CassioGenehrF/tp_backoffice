<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeriodPackageToPropertyValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_value', function (Blueprint $table) {
            $table->dropColumn('max_people_package_start')->nullable();
            $table->dropColumn('price_package_start')->nullable();
            $table->dropColumn('min_people_package_2')->nullable();
            $table->dropColumn('max_people_package_2')->nullable();
            $table->dropColumn('price_package_2')->nullable();
            $table->dropColumn('min_people_package_3')->nullable();
            $table->dropColumn('max_people_package_3')->nullable();
            $table->dropColumn('price_package_3')->nullable();
            $table->dropColumn('min_people_package_4')->nullable();
            $table->dropColumn('max_people_package_4')->nullable();
            $table->dropColumn('price_package_4')->nullable();
            $table->dropColumn('min_people_package_5')->nullable();
            $table->dropColumn('max_people_package_5')->nullable();
            $table->dropColumn('price_package_5')->nullable();

            $table->integer('max_people_package_start_weekend')->nullable();
            $table->decimal('price_package_start_weekend')->nullable();
            $table->integer('min_people_package_2_weekend')->nullable();
            $table->integer('max_people_package_2_weekend')->nullable();
            $table->decimal('price_package_2_weekend')->nullable();
            $table->integer('min_people_package_3_weekend')->nullable();
            $table->integer('max_people_package_3_weekend')->nullable();
            $table->decimal('price_package_3_weekend')->nullable();
            $table->integer('min_people_package_4_weekend')->nullable();
            $table->integer('max_people_package_4_weekend')->nullable();
            $table->decimal('price_package_4_weekend')->nullable();
            $table->integer('min_people_package_5_weekend')->nullable();
            $table->integer('max_people_package_5_weekend')->nullable();
            $table->decimal('price_package_5_weekend')->nullable();

            $table->integer('max_people_package_start_day_use')->nullable();
            $table->decimal('price_package_start_day_use')->nullable();
            $table->integer('min_people_package_2_day_use')->nullable();
            $table->integer('max_people_package_2_day_use')->nullable();
            $table->decimal('price_package_2_day_use')->nullable();
            $table->integer('min_people_package_3_day_use')->nullable();
            $table->integer('max_people_package_3_day_use')->nullable();
            $table->decimal('price_package_3_day_use')->nullable();
            $table->integer('min_people_package_4_day_use')->nullable();
            $table->integer('max_people_package_4_day_use')->nullable();
            $table->decimal('price_package_4_day_use')->nullable();
            $table->integer('min_people_package_5_day_use')->nullable();
            $table->integer('max_people_package_5_day_use')->nullable();
            $table->decimal('price_package_5_day_use')->nullable();

            $table->integer('max_people_package_start_week')->nullable();
            $table->decimal('price_package_start_week')->nullable();
            $table->integer('min_people_package_2_week')->nullable();
            $table->integer('max_people_package_2_week')->nullable();
            $table->decimal('price_package_2_week')->nullable();
            $table->integer('min_people_package_3_week')->nullable();
            $table->integer('max_people_package_3_week')->nullable();
            $table->decimal('price_package_3_week')->nullable();
            $table->integer('min_people_package_4_week')->nullable();
            $table->integer('max_people_package_4_week')->nullable();
            $table->decimal('price_package_4_week')->nullable();
            $table->integer('min_people_package_5_week')->nullable();
            $table->integer('max_people_package_5_week')->nullable();
            $table->decimal('price_package_5_week')->nullable();

            $table->integer('max_people_package_start_holiday')->nullable();
            $table->decimal('price_package_start_holiday')->nullable();
            $table->integer('min_people_package_2_holiday')->nullable();
            $table->integer('max_people_package_2_holiday')->nullable();
            $table->decimal('price_package_2_holiday')->nullable();
            $table->integer('min_people_package_3_holiday')->nullable();
            $table->integer('max_people_package_3_holiday')->nullable();
            $table->decimal('price_package_3_holiday')->nullable();
            $table->integer('min_people_package_4_holiday')->nullable();
            $table->integer('max_people_package_4_holiday')->nullable();
            $table->decimal('price_package_4_holiday')->nullable();
            $table->integer('min_people_package_5_holiday')->nullable();
            $table->integer('max_people_package_5_holiday')->nullable();
            $table->decimal('price_package_5_holiday')->nullable();

            $table->integer('max_people_package_start_christmas')->nullable();
            $table->decimal('price_package_start_christmas')->nullable();
            $table->integer('min_people_package_2_christmas')->nullable();
            $table->integer('max_people_package_2_christmas')->nullable();
            $table->decimal('price_package_2_christmas')->nullable();
            $table->integer('min_people_package_3_christmas')->nullable();
            $table->integer('max_people_package_3_christmas')->nullable();
            $table->decimal('price_package_3_christmas')->nullable();
            $table->integer('min_people_package_4_christmas')->nullable();
            $table->integer('max_people_package_4_christmas')->nullable();
            $table->decimal('price_package_4_christmas')->nullable();
            $table->integer('min_people_package_5_christmas')->nullable();
            $table->integer('max_people_package_5_christmas')->nullable();
            $table->decimal('price_package_5_christmas')->nullable();

            $table->integer('max_people_package_start_new_year')->nullable();
            $table->decimal('price_package_start_new_year')->nullable();
            $table->integer('min_people_package_2_new_year')->nullable();
            $table->integer('max_people_package_2_new_year')->nullable();
            $table->decimal('price_package_2_new_year')->nullable();
            $table->integer('min_people_package_3_new_year')->nullable();
            $table->integer('max_people_package_3_new_year')->nullable();
            $table->decimal('price_package_3_new_year')->nullable();
            $table->integer('min_people_package_4_new_year')->nullable();
            $table->integer('max_people_package_4_new_year')->nullable();
            $table->decimal('price_package_4_new_year')->nullable();
            $table->integer('min_people_package_5_new_year')->nullable();
            $table->integer('max_people_package_5_new_year')->nullable();
            $table->decimal('price_package_5_new_year')->nullable();

            $table->integer('max_people_package_start_carnival')->nullable();
            $table->decimal('price_package_start_carnival')->nullable();
            $table->integer('min_people_package_2_carnival')->nullable();
            $table->integer('max_people_package_2_carnival')->nullable();
            $table->decimal('price_package_2_carnival')->nullable();
            $table->integer('min_people_package_3_carnival')->nullable();
            $table->integer('max_people_package_3_carnival')->nullable();
            $table->decimal('price_package_3_carnival')->nullable();
            $table->integer('min_people_package_4_carnival')->nullable();
            $table->integer('max_people_package_4_carnival')->nullable();
            $table->decimal('price_package_4_carnival')->nullable();
            $table->integer('min_people_package_5_carnival')->nullable();
            $table->integer('max_people_package_5_carnival')->nullable();
            $table->decimal('price_package_5_carnival')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_value', function (Blueprint $table) {
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

            $table->dropColumn('max_people_package_start_weekend');
            $table->dropColumn('price_package_start_weekend');
            $table->dropColumn('min_people_package_2_weekend');
            $table->dropColumn('max_people_package_2_weekend');
            $table->dropColumn('price_package_2_weekend');
            $table->dropColumn('min_people_package_3_weekend');
            $table->dropColumn('max_people_package_3_weekend');
            $table->dropColumn('price_package_3_weekend');
            $table->dropColumn('min_people_package_4_weekend');
            $table->dropColumn('max_people_package_4_weekend');
            $table->dropColumn('price_package_4_weekend');
            $table->dropColumn('min_people_package_5_weekend');
            $table->dropColumn('max_people_package_5_weekend');
            $table->dropColumn('price_package_5_weekend');

            $table->dropColumn('max_people_package_start_day_use');
            $table->dropColumn('price_package_start_day_use');
            $table->dropColumn('min_people_package_2_day_use');
            $table->dropColumn('max_people_package_2_day_use');
            $table->dropColumn('price_package_2_day_use');
            $table->dropColumn('min_people_package_3_day_use');
            $table->dropColumn('max_people_package_3_day_use');
            $table->dropColumn('price_package_3_day_use');
            $table->dropColumn('min_people_package_4_day_use');
            $table->dropColumn('max_people_package_4_day_use');
            $table->dropColumn('price_package_4_day_use');
            $table->dropColumn('min_people_package_5_day_use');
            $table->dropColumn('max_people_package_5_day_use');
            $table->dropColumn('price_package_5_day_use');

            $table->dropColumn('max_people_package_start_week');
            $table->dropColumn('price_package_start_week');
            $table->dropColumn('min_people_package_2_week');
            $table->dropColumn('max_people_package_2_week');
            $table->dropColumn('price_package_2_week');
            $table->dropColumn('min_people_package_3_week');
            $table->dropColumn('max_people_package_3_week');
            $table->dropColumn('price_package_3_week');
            $table->dropColumn('min_people_package_4_week');
            $table->dropColumn('max_people_package_4_week');
            $table->dropColumn('price_package_4_week');
            $table->dropColumn('min_people_package_5_week');
            $table->dropColumn('max_people_package_5_week');
            $table->dropColumn('price_package_5_week');

            $table->dropColumn('max_people_package_start_holiday');
            $table->dropColumn('price_package_start_holiday');
            $table->dropColumn('min_people_package_2_holiday');
            $table->dropColumn('max_people_package_2_holiday');
            $table->dropColumn('price_package_2_holiday');
            $table->dropColumn('min_people_package_3_holiday');
            $table->dropColumn('max_people_package_3_holiday');
            $table->dropColumn('price_package_3_holiday');
            $table->dropColumn('min_people_package_4_holiday');
            $table->dropColumn('max_people_package_4_holiday');
            $table->dropColumn('price_package_4_holiday');
            $table->dropColumn('min_people_package_5_holiday');
            $table->dropColumn('max_people_package_5_holiday');
            $table->dropColumn('price_package_5_holiday');

            $table->dropColumn('max_people_package_start_christmas');
            $table->dropColumn('price_package_start_christmas');
            $table->dropColumn('min_people_package_2_christmas');
            $table->dropColumn('max_people_package_2_christmas');
            $table->dropColumn('price_package_2_christmas');
            $table->dropColumn('min_people_package_3_christmas');
            $table->dropColumn('max_people_package_3_christmas');
            $table->dropColumn('price_package_3_christmas');
            $table->dropColumn('min_people_package_4_christmas');
            $table->dropColumn('max_people_package_4_christmas');
            $table->dropColumn('price_package_4_christmas');
            $table->dropColumn('min_people_package_5_christmas');
            $table->dropColumn('max_people_package_5_christmas');
            $table->dropColumn('price_package_5_christmas');

            $table->dropColumn('max_people_package_start_new_year');
            $table->dropColumn('price_package_start_new_year');
            $table->dropColumn('min_people_package_2_new_year');
            $table->dropColumn('max_people_package_2_new_year');
            $table->dropColumn('price_package_2_new_year');
            $table->dropColumn('min_people_package_3_new_year');
            $table->dropColumn('max_people_package_3_new_year');
            $table->dropColumn('price_package_3_new_year');
            $table->dropColumn('min_people_package_4_new_year');
            $table->dropColumn('max_people_package_4_new_year');
            $table->dropColumn('price_package_4_new_year');
            $table->dropColumn('min_people_package_5_new_year');
            $table->dropColumn('max_people_package_5_new_year');
            $table->dropColumn('price_package_5_new_year');

            $table->dropColumn('max_people_package_start_carnival');
            $table->dropColumn('price_package_start_carnival');
            $table->dropColumn('min_people_package_2_carnival');
            $table->dropColumn('max_people_package_2_carnival');
            $table->dropColumn('price_package_2_carnival');
            $table->dropColumn('min_people_package_3_carnival');
            $table->dropColumn('max_people_package_3_carnival');
            $table->dropColumn('price_package_3_carnival');
            $table->dropColumn('min_people_package_4_carnival');
            $table->dropColumn('max_people_package_4_carnival');
            $table->dropColumn('price_package_4_carnival');
            $table->dropColumn('min_people_package_5_carnival');
            $table->dropColumn('max_people_package_5_carnival');
            $table->dropColumn('price_package_5_carnival');
        });
    }
}
