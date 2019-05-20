<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modeloventor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('autofecha')->useCurrent();
            $table->string('modelo_y_a',120)->nullable()->default(NULL);
            $table->unsignedBigInteger('marca_id')->nullable()->default(NULL);

            $table->foreign('marca_id')->references('id')->on('marcasventor')->onDelete('cascade');
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
        Schema::dropIfExists('modeloventor');
    }
}
