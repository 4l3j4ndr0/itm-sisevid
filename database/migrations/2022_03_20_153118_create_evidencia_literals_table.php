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
        Schema::create('evidencia_literales', function (Blueprint $table) {
            $table->foreignId('evidencia_id_fk')->references('id')->on('evidencias');
            $table->foreignId('literal_id_fk')->references('id')->on('literales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencia_literales');
    }
};
