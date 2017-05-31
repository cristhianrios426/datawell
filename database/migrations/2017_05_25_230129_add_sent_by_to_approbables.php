<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSentByToApprobables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['services', 
                    'wells',
                    'attachments'];
        foreach ($tables as $key => $tablename) {
            Schema::table($tablename, function(Blueprint $table)
            {
                $table->integer('sent_by')->unsigned()->nullable();
                $table->foreign('sent_by')->references('id')->on('users');
                
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = ['services', 
                    'wells',
                    'attachments'];
        foreach ($tables as $key => $tablename) {
            if(\Schema::hasColumn($tablename, 'sent_by')){
                Schema::table($tablename, function(Blueprint $table) use ($tablename)
                {
                    $table->dropForeign($tablename.'_sent_by_foreign');
                    $table->dropColumn('sent_by');
                });
            }
        }
    }
}
