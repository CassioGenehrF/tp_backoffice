<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationToPropertyInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_info', function (Blueprint $table) {
            $table->string('location_lat', 255)->nullable();
            $table->string('location_lng', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_info', function (Blueprint $table) {
            $table->dropColumn('location_lat');
            $table->dropColumn('location_lng');
        });
    }
}
