<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencia_numerales', function (Blueprint $table) {
            $table->foreignId('evidencia_id_fk')->references('id')->on('evidencias');
            $table->foreignId('numeral_id_fk')->references('id')->on('numerales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencia_numerales');
    }
};
