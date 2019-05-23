<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partesventor', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->timestamp('autofecha')->useCurrent();
            $table->string('cod',15)->nullable()->default(NULL);
            $table->string('descrp',120)->nullable()->default(NULL);
            $table->unsignedBigInteger('familia_id')->nullable()->default(NULL);

            $table->foreign('familia_id')->references('id')->on('familiasventor')->onDelete('cascade');
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
        Schema::dropIfExists('partesventor');
    }
}
