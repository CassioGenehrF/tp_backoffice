<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id');
            $table->string('owner_name', 255)->nullable();
            $table->string('owner_cpf', 20)->nullable();
            $table->string('owner_address', 255)->nullable();
            $table->string('owner_cep', 20)->nullable();
            $table->string('owner_city', 255)->nullable();
            $table->string('owner_uf', 255)->nullable();
            $table->string('owner_phone_number', 255)->nullable();
            $table->string('client_name', 255)->nullable();
            $table->string('client_cpf', 20)->nullable();
            $table->string('client_address', 255)->nullable();
            $table->string('client_cep', 20)->nullable();
            $table->string('client_city', 255)->nullable();
            $table->string('client_uf', 255)->nullable();
            $table->string('client_phone_number', 255)->nullable();
            $table->string('property_address', 255)->nullable();
            $table->string('property_city', 255)->nullable();
            $table->string('property_uf', 255)->nullable();
            $table->integer('rented_days')->nullable();
            $table->date('checkin_date')->nullable();
            $table->dateTime('checkin_hour')->nullable();
            $table->dateTime('checkin_limit_hour')->nullable();
            $table->date('checkout_date')->nullable();
            $table->dateTime('checkout_hour')->nullable();
            $table->integer('guests_number')->nullable();
            $table->float('excess_value', 8, 2)->nullable();
            $table->float('rent_value', 8, 2)->nullable();
            $table->float('signal_value', 8, 2)->nullable();
            $table->float('clean_tax', 8, 2)->nullable();
            $table->float('bail_tax', 8, 2)->nullable();
            $table->boolean('allow_pet')->default(true);
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
        Schema::dropIfExists('contract_clients');
    }
}
