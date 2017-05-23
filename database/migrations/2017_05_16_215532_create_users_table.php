<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->softDeletes();
			$table->string('name');
			$table->string('email');
			$table->string('password');
			$table->integer('ide_type');
			$table->string('address')->default('');			
			$table->string('job_phone')->default('');
			
			$table->integer('role_id');
			$table->integer('location_id')->unsigned()->nullable();
			$table->foreign('location_id')->references('id')->on('locations');
			$table->integer('client_id')->unsigned()->nullable();
			$table->foreign('client_id')->references('id')->on('clients');

			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('ide')->default('');
			$table->string('cell')->nullable();
			$table->string('job_cell')->nullable();
			$table->string('job_address')->nullable();
			$table->string('phone')->nullable();
			$table->integer('state')->nullable();
			$table->boolean('is_actived')->nullable();
			$table->string('activation_token')->nullable();
			$table->dateTime('expire_token')->default('0000-00-00 00:00:00');
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
