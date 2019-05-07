<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo',100)->nullable()->default(NULL);
            $table->string('zona',100)->nullable()->default(NULL);
            $table->text('descripcion')->nullable()->default(NULL);
            $table->string('orden',3)->nullable()->default(NULL);
            $table->boolean('in_zone')->default(false);//DOMICILIO en zona
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
        Schema::dropIfExists('recursos');
    }
}
