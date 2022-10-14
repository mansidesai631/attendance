<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->string('logo',255)->nullable()->after('name');
            $table->dropColumn('default_manager');
            $table->foreignId('default_manager_id')->nullable()->after('addess')->references('id')->on('employees');
            $table->string('code',5)->default('91')->change();
            $table->integer('ad_limit')->nullable()->default(0)->change();
        });

        DB::statement("ALTER TABLE sites CHANGE COLUMN employee_mode employee_mode ENUM('PERMANENT', 'CONTRACT', 'BOTH') NOT NULL DEFAULT 'PERMANENT'");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('logo');
            $table->dropForeign('sites_default_manager_id_foreign');
            $table->dropColumn('default_manager_id');
            $table->bigInteger('default_manager');
            $table->string('code',5)->change();
            $table->integer('ad_limit')->change();

        });
    }
};
