<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('nombre')->nullable()->default(NULL);
            $table->string('image',150)->nullable()->default(NULL);
            $table->string('color',10)->nullable()->default(NULL);
            $table->string('hsl',100)->nullable()->default(NULL);
            $table->unsignedBigInteger('padre_id')->default(0);
            $table->foreign('padre_id')->references('id')->on('categorias')->onDelete('cascade');
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
        Schema::dropIfExists('categorias');
    }
}
