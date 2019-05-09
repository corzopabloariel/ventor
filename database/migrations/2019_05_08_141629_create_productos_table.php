<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('orden',10)->nullable()->default(NULL);
            $table->string('codigo',15)->nullable()->default(NULL);
            $table->string('nombre',100)->nullable()->default(NULL);
            $table->string('image',150)->nullable()->default(NULL);
            $table->string('catalogo',150)->nullable()->default(NULL);
            $table->string('link',100)->nullable()->default(NULL);
            $table->string('mercadolibre',150)->nullable()->default(NULL);
            $table->integer('cantidad')->default(0);
            
            $table->unsignedBigInteger('familia_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('categoria_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('origen_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('marca_id')->nullable()->default(NULL);

            $table->foreign('familia_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('set null');
            $table->foreign('origen_id')->references('id')->on('origenes')->onDelete('set null');
            $table->foreign('marca_id')->references('id')->on('marcas')->onDelete('set null');
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
        Schema::dropIfExists('productos');
    }
}
