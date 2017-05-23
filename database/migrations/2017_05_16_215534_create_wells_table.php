<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWellsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wells', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('x')->nullable();
			$table->string('y')->nullable();
			$table->string('z')->nullable();
			$table->integer('profundidad_tvd')->nullable();
			$table->integer('profundidad_md')->nullable();
			$table->string('well_kb_elev', 45)->nullable();
			$table->string('rotaty_elev', 45)->nullable();
			$table->integer('location_id')->unsigned()->nullable();
			$table->foreign('location_id')->references('id')->on('locations');
			
			$table->integer('area_id')->unsigned()->nullable();
			$table->foreign('area_id')->references('id')->on('areas');
			
			$table->integer('camp_id')->unsigned()->nullable();
			$table->foreign('camp_id')->references('id')->on('camps');
			
			$table->integer('cuenca_id')->unsigned()->nullable();
			$table->foreign('cuenca_id')->references('id')->on('cuencas');
			
			$table->integer('block_id')->unsigned()->nullable();
			$table->foreign('block_id')->references('id')->on('blocks');
			
			$table->integer('ref_cor_sis_id')->unsigned()->nullable();
			$table->foreign('ref_cor_sis_id')->references('id')->on('coordinates_sys');
			
			$table->integer('operator_id')->unsigned()->nullable();
			$table->foreign('operator_id')->references('id')->on('operators');
			
			$table->integer('well_type_id')->unsigned()->nullable();
			$table->foreign('well_type_id')->references('id')->on('well_types');
			
			$table->integer('deviation_id')->unsigned()->nullable();
			$table->foreign('deviation_id')->references('id')->on('deviations');
			
			$table->dateTime('drilled_at')->nullable();
			$table->string('lat')->nullable();
			$table->string('long')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wells');
	}

}
