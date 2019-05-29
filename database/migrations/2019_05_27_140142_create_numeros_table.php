<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numeros', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('provincia',150)->nullable()->default(NULL);
            $table->string('nombre',20)->nullable()->default(NULL);
            $table->string('persona',150)->nullable()->default(NULL);
            $table->string('interno',50)->nullable()->default(NULL);
            $table->text('email')->nullable()->default(NULL);
            $table->boolean('is_vendedor')->default(false);
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
        Schema::dropIfExists('numeros');
    }
}
