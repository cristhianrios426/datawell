<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsWellOperations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Schema::disableForeignKeyConstraints();
        Schema::table('wells', function(Blueprint $table)
        {
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users');

            $table->integer('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users');

        });

        Schema::table('services', function(Blueprint $table)
        {
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users');

            $table->integer('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            
        }); 

        Schema::table('attachments', function(Blueprint $table)
        {
            $table->integer('created_by')->unsigned()->nullable();
            $table->foreign('created_by')->references('id')->on('users');

            $table->integer('assigned_to')->unsigned()->nullable();
            $table->foreign('assigned_to')->references('id')->on('users');

            $table->integer('approved_by')->unsigned()->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            
        });

        Schema::create('revisions', function(Blueprint $table)
        {
           $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->text('content')->default('');
            $table->boolean('is_valid')->default(0);
            $table->morphs('revisable');
            
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wells', function(Blueprint $table)
        {
            $table->dropColumn(['created_by', 'asigned_to', 'approved_by']);
           
        });

        Schema::table('services', function(Blueprint $table)
        {
            $table->dropColumn(['created_by', 'asigned_to', 'approved_by']);
           
        });

        Schema::table('attachments', function(Blueprint $table)
        {
            $table->dropColumn(['created_by', 'asigned_to', 'approved_by']);
           
        });

        Schema::table('attachments', function(Blueprint $table)
        {
            $table->drop('revisions');
           
        });
    }
}
