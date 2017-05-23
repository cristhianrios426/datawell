<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStateToAll extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = ['wells', 'services', 'attachments', ];
        foreach ($tables as $key => $tablename) {
            Schema::table($tablename, function(Blueprint $table) use ($tablename)
            {
                if (!Schema::hasColumn($tablename, 'state')) {
                    $table->integer('state');
                }

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
        $tables = ['wells', 'services', 'attachments', ];
        foreach ($tables as $key => $tablename) {
            Schema::table($tablename, function(Blueprint $table) use ($tablename)
            {
                if (Schema::hasColumn($tablename, 'state')) {
                    $table->dropColumn('state');
                }

            });
        }
    }
}
