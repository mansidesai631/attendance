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
        Schema::table('inspections', function (Blueprint $table) {
            $table->decimal('before_lat', 10, 6)->nullable()->change();
            $table->decimal('before_long', 10, 6)->nullable()->change();
            $table->decimal('after_lat', 10, 6)->nullable()->change();
            $table->decimal('after_long', 10, 6)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inspections', function (Blueprint $table) {
            //
        });
    }
};
