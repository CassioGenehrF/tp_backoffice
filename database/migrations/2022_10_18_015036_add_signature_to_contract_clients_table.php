<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSignatureToContractClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_clients', function (Blueprint $table) {
            $table->string('client_signature')->nullable();
            $table->dateTime('client_signature_at')->nullable();
            $table->string('owner_signature')->nullable();
            $table->dateTime('owner_signature_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contract_clients', function (Blueprint $table) {
            $table->dropColumn('client_signature');
            $table->dropColumn('client_signature_at');
            $table->dropColumn('owner_signature');
            $table->dropColumn('owner_signature_at');
        });
    }
}
