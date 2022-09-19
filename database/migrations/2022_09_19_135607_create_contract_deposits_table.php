<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_deposits', function (Blueprint $table) {
            $table->id();
            $table->string('bank', 255)->nullable();
            $table->string('agency', 255)->nullable();
            $table->string('account', 255)->nullable();
            $table->string('responsible', 255)->nullable();
            $table->string('responsible_cpf', 20)->nullable();
            $table->string('pix', 255)->nullable();
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
        Schema::dropIfExists('contract_deposits');
    }
}
