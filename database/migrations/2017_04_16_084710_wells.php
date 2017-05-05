<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Wells extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('wells', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->float('x')->nullable();
            $table->float('y')->nullable();
            $table->float('z')->nullable();
            $table->integer('profundidad_tvd')->nullable();
            $table->integer('profundidad_md')->nullable();
            $table->string('well_kb_elev', 45)->nullable();
            $table->string('rotaty_elev', 45)->nullable();
            $table->integer('id_mun')->nullable();
            $table->integer('id_area')->nullable();
            $table->integer('id_camp')->nullable();
            $table->integer('id_cuenca')->nullable();
            $table->integer('id_block')->nullable();
            $table->integer('id_ref_cor_sis')->nullable();
            $table->integer('id_operator')->nullable();
            $table->integer('id_well_type')->nullable();
            $table->integer('id_deviation')->nullable();
            $table->dateTime('drilled_at')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
     {
       Schema::dropIfExists('wells');
     }
}
