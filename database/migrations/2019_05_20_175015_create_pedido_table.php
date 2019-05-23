<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePedidoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('autofecha')->useCurrent();
            
            $table->unsignedBigInteger('cliente_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('vendedor_id')->nullable()->default(NULL);
            $table->unsignedBigInteger('transporte_id')->nullable()->default(NULL);

            $table->foreign('cliente_id')->references('id')->on('clientesventor')->onDelete('set null');
            $table->foreign('vendedor_id')->references('id')->on('vendedoresventor')->onDelete('set null');
            $table->foreign('transporte_id')->references('id')->on('transportesventor')->onDelete('set null');

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
        Schema::dropIfExists('pedidos');
    }
}
