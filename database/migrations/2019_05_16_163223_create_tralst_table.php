<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTralstTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transportesventor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('tradcod')->nullable()->default(0);
            $table->string('descrp',60)->nullable()->default(NULL);
            $table->string('tradir',100)->nullable()->default(NULL);
            $table->string('telefn',50)->nullable()->default(NULL);
            $table->string('respon',50)->nullable()->default(NULL);

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
        Schema::dropIfExists('transportesventor');
    }
}
