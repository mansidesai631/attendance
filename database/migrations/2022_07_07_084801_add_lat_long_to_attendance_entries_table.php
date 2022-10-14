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
        Schema::table('attendance_entries', function (Blueprint $table) {
            $table->decimal('in_latitude',10,6)->nullable()->after('in_time');
            $table->decimal('in_longitude',10,6)->nullable()->after('in_latitude');
            $table->decimal('out_latitude',10,6)->nullable()->after('out_time');
            $table->decimal('out_longitude',10,6)->nullable()->after('out_latitude');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_entries', function (Blueprint $table) {
            //
        });
    }
};
