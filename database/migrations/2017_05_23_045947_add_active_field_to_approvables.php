<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActiveFieldToApprovables extends Migration
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
        foreach ($tables as $key => $table) {
            Schema::table($table, function(Blueprint $table)
            {

                $table->timestamp('approved_at')->nullable();
                $table->boolean('approved')->nullable();
                $table->boolean('draft')->nullable();
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
        foreach ($tables as $key => $tableName) {            
            Schema::table($tableName, function(Blueprint $table) use ($tableName)
            {
                foreach (['approved_at', 'approved', 'draft'] as $key => $field) {
                    if(Schema::hasColumn($tableName, $field)){
                        $table->dropColumn($field);                       
                    }else{
                        echo 'no';
                    }
                }
            });
        }
    }
}
