<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name')->nullable();
            $table->string('cpf')->nullable();
            $table->string('phone')->nullable();
            $table->string('message')->nullable();
            $table->enum('feedback_stars', [1, 2, 3, 4, 5]);
            $table->string('feedback_positive')->nullable();
            $table->string('feedback_negative')->nullable();
            $table->enum('status', ['Ativo', 'Pendente', 'Deletando'])->default('Pendente');
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
        Schema::dropIfExists('clients');
    }
}
