<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedByToAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['locations', 
                    'clients', 
                    'users',
                     'areas', 
                     'blocks',
                     'business_units',
                     'camps',
                     'coordinates_sys',
                     'cuencas',
                     'deviations',
                     'operators',
                     'sections',
                    'well_types',
                     'service_types',
                     'revisions',
                     ];
        foreach ($tables as $key => $table) {
            Schema::table($table, function(Blueprint $table)
            {
                $table->integer('created_by')->unsigned()->nullable();
                $table->foreign('created_by')->references('id')->on('users');

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
        //
    }
}
