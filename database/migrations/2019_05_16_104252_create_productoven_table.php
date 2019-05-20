<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductovenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productosventor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('stmpdh_art',254)->nullable()->default(NULL);
            $table->string('use',254)->nullable()->default(NULL);
            $table->string('codigo_ima',254)->nullable()->default(NULL);
            $table->string('stmpdh_tex',254)->nullable()->default(NULL);
            $table->string('usr_stmpdh',254)->nullable()->default(NULL);//PRE. 5 DEC
            $table->double('precio',8,5)->nullable()->default(0);
            $table->string('web_marcas',254)->nullable()->default(NULL);
            //$table->string('parte',254)->nullable()->default(NULL);
            $table->string('parte_dbf_',254)->nullable()->default(NULL);
            $table->string('modelo_y_a',254)->nullable()->default(NULL);
            $table->string('usr_stmati',254)->nullable()->default(NULL);
            $table->string('grupo_web',254)->nullable()->default(NULL);//PRE. 5 DEC
            $table->string('cantminvta',254)->nullable()->default(NULL);//PRE. 5 DEC
            $table->dateTime('fecha_ingr')->nullable()->default(NULL);
            $table->string('nro_refere',254)->nullable()->default(NULL);

            
            $table->unsignedBigInteger('familia_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('parte_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('modelo_id')->nullable()->default(NULL);

            $table->foreign('familia_id')->references('id')->on('familiasventor')->onDelete('set null');
            $table->foreign('parte_id')->references('id')->on('partesventor')->onDelete('set null');
            $table->foreign('modelo_id')->references('id')->on('modeloventor')->onDelete('set null');
            
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
        Schema::dropIfExists('productosventor');
    }
}
