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
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tipo_evidencia_id_fk')->references('id')->on('tipo_evidencias');
            $table->string('codigo');
            $table->string('titulo');
            $table->dateTime('fecha_creacion');
            $table->dateTime('fecha_modificacion');
            $table->string('url_evidencia', 500);
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
        Schema::dropIfExists('evidencias');
    }
};
