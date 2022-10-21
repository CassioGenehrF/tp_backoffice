<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBackofficeRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backoffice_reminders', function (Blueprint $table) {
            $table->id();
            $table->date('checkin');
            $table->date('checkout');
            $table->string('client');
            $table->string('phone');
            $table->decimal('price', 8, 2);
            $table->integer('people_number');
            $table->string('period');
            $table->unsignedBigInteger('property_id');
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
        Schema::dropIfExists('backoffice_reminders');
    }
}
