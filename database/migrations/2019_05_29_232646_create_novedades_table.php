<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNovedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novedades', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('documento',150)->nullable()->default(NULL);
            $table->string('image',150)->nullable()->default(NULL);
            $table->string('nombre',150)->nullable()->default(NULL);
            $table->string('url',170)->nullable()->default(NULL);
            $table->string('orden',3)->nullable()->default(NULL);
            
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
        Schema::dropIfExists('novedades');
    }
}
