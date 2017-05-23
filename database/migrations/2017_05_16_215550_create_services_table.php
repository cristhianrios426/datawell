<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->softDeletes();
			$table->string('name');
			$table->text('description', 65535);
			$table->integer('service_type_id')->unsigned()->nullable();
			$table->foreign('service_type_id')->references('id')->on('service_types');
			$table->integer('section_id')->unsigned()->nullable();
			$table->foreign('section_id')->references('id')->on('sections');
			$table->integer('client_id')->unsigned()->nullable();
			$table->foreign('client_id')->references('id')->on('clients');
			$table->integer('well_id')->unsigned()->nullable();
			$table->foreign('well_id')->references('id')->on('wells');
			$table->dateTime('ended_at');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('services');
	}

}
