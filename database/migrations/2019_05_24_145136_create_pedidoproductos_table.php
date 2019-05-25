<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidoproductos', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->integer('cnt')->nullable()->default(NULL);
            $table->unsignedBigInteger('producto_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('pedido_id')->nullable()->default(NULL);
            $table->string('observ',100)->nullable()->default(NULL);
            
            $table->foreign('producto_id')->references('id')->on('productosventor')->onDelete('set null');
            $table->foreign('pedido_id')->references('id')->on('pedidos')->onDelete('set null');
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
        Schema::dropIfExists('pedidoproductos');
    }
}
