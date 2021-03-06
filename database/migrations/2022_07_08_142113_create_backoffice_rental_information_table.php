<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackofficeRentalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice_rental_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('commitment_id');
            $table->string('guest_name');
            $table->string('guest_phone');
            $table->decimal('price', 8, 2);
            $table->integer('adults');
            $table->integer('kids');
            $table->string('contract');
            $table->decimal('site_tax', 8, 2);
            $table->decimal('broker_tax', 8, 2);
            $table->decimal('publisher_tax', 8, 2);
            $table->decimal('regional_tax', 8, 2);
            $table->decimal('bail_tax', 8, 2);
            $table->decimal('clean_tax', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('backoffice_rental_information');
    }
}
