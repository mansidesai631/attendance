<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('field_monitorings', function (Blueprint $table) {
            $table->string('distance',55)->after('circle')->nullable();
            $table->double('latitude',8,6)->after('distance')->nullable();
            $table->double('longitude',8,6)->after('latitude')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('field_monitorings', function (Blueprint $table) {
            //
        });
    }
};
