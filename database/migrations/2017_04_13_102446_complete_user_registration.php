<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CompleteUserRegistration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
       
        try {
            Schema::create('ide_types', function(Blueprint $table){
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('name')->default('');
            });

            Schema::create('cities', function(Blueprint $table){
                $table->increments('id');
                $table->timestamps();
                $table->softDeletes();
                $table->string('name')->default('');
            });

            // Schema::table('users', function (Blueprint $table){
            //     $table->integer('id_city')->unisined()->change();
            //     $table->foreign('id_city')->references('id')->on('cities');
            // });

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('users', function (Blueprint $table) {
        //     $table->dropColumn('ide_type');
        //     $table->dropColumn('address');
        //     $table->dropColumn('city');            
        //     $table->dropColumn('job_phone');
        // });
        Schema::dropIfExists('ide_types');
        Schema::dropIfExists('cities');
        

        
    }
}
