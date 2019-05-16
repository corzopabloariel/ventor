<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientesventor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nrocta',15)->nullable()->default(NULL);
            $table->string('nombre',120)->nullable()->default(NULL);
            $table->string('respon',60)->nullable()->default(NULL);
            $table->string('usrvtmcl',30)->nullable()->default(NULL);
            $table->string('usrvt_001',30)->nullable()->default(NULL);
            $table->string('usrvt_002',50)->nullable()->default(NULL);
            $table->string('direcc',60)->nullable()->default(NULL);
            $table->string('codpos',10)->nullable()->default(NULL);
            $table->string('descrp',60)->nullable()->default(NULL);
            $table->string('descr_001',60)->nullable()->default(NULL);
            $table->string('telefn',30)->nullable()->default(NULL);
            $table->string('nrofax',20)->nullable()->default(NULL);
            $table->string('direml',60)->nullable()->default(NULL);
            $table->string('nrodoc',50)->nullable()->default(NULL);
            $table->string('descr_002',60)->nullable()->default(NULL);
            $table->string('usrvt_003',60)->nullable()->default(NULL);
            $table->string('vnddor',6)->nullable()->default(NULL);
            $table->string('descr_003',60)->nullable()->default(NULL);
            $table->string('nrotel',30)->nullable()->default(NULL);
            $table->string('camail',60)->nullable()->default(NULL);

            $table->string('usrvt_004',10)->nullable()->default(NULL);
            $table->string('usrvt_005',10)->nullable()->default(NULL);
            $table->string('usrvt_006',10)->nullable()->default(NULL);
            $table->string('usrvt_007',10)->nullable()->default(NULL);
            $table->string('usrvt_008',10)->nullable()->default(NULL);
            $table->string('usrvt_009',10)->nullable()->default(NULL);
            $table->string('usrvt_010',10)->nullable()->default(NULL);
            $table->string('usrvt_011',10)->nullable()->default(NULL);
            $table->string('usrvt_012',10)->nullable()->default(NULL);
            $table->string('usrvt_013',10)->nullable()->default(NULL);
            $table->string('usrvt_014',10)->nullable()->default(NULL);
            $table->string('usrvt_015',10)->nullable()->default(NULL);
            $table->string('usrvt_016',10)->nullable()->default(NULL);
            $table->string('usrvt_017',10)->nullable()->default(NULL);
            $table->string('usrvt_018',10)->nullable()->default(NULL);
            $table->string('usrvt_019',10)->nullable()->default(NULL);
            $table->string('usrvt_020',10)->nullable()->default(NULL);
            $table->string('usrvt_021',10)->nullable()->default(NULL);

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
        Schema::dropIfExists('clientesventor');
    }
}
