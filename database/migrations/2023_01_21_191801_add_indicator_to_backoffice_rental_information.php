<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndicatorToBackofficeRentalInformation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('backoffice_rental_information', function (Blueprint $table) {
            $table->unsignedBigInteger('indicator');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('backoffice_rental_information', function (Blueprint $table) {
            $table->dropColumn('indicator');
        });
    }
}
