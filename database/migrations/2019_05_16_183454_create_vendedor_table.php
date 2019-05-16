<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendedoresventor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('vnddor',10)->nullable()->default(NULL);
            $table->string('descrp',60)->nullable()->default(NULL);
            $table->string('natmer',20)->nullable()->default(NULL);
            $table->string('nrotel',30)->nullable()->default(NULL);
            $table->string('mail',200)->nullable()->default(NULL);

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
        Schema::dropIfExists('vendedoresventor');
    }
}
