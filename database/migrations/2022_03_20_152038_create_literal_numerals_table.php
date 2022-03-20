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
        Schema::create('literal_numerales', function (Blueprint $table) {
            $table->foreignId('literal_id_fk')->references('id')->on('literales');
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
        Schema::dropIfExists('literal_numerales');
    }
};
