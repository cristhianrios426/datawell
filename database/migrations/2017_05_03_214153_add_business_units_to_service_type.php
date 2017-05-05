<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBusinessUnitsToServiceType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_types', function (Blueprint $table) {
            $table->integer('business_unit_id')->references('id')->on('business_units');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('service_types', function (Blueprint $table) {
            $table->dropColumn('business_unit_id');
        });
    }
}
