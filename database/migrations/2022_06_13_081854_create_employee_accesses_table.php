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
        Schema::create('employee_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');            
            $table->integer('ad_from_kiosk')->nullable();
            $table->boolean('allow_from_user_app')->default(0)->nullable();
            $table->boolean('ad_anywhere')->default(0)->nullable();
            $table->boolean('ad_allowed_location')->default(0)->nullable();
            $table->integer('attendance_location_id')->nullable();
            $table->integer('additional_site_access')->nullable();
            $table->boolean('user_can_be_added_as_manager')->default(0)->nullable();
            $table->boolean('manager_approval_for_each_attendance')->default(0)->nullable();
            $table->boolean('invite_user')->default(0)->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_accesses');
    }
};
