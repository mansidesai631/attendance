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
        Schema::table('employee_others', function (Blueprint $table) {
            $table->string('father_name',20)->nullable()->change();
            $table->string('permanent_address',50)->nullable()->change();
            $table->string('communication_address',50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_others', function (Blueprint $table) {
            //
        });
    }
};
