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
        Schema::create('employee_works', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->date('joining_date')->nullable();
            $table->date('deactivate_date')->nullable();
            $table->integer('department_id')->index();
            $table->integer('designation_id')->index();
            $table->string('manager',20)->index();
            $table->bigInteger('base_site_id')->index();
            $table->string('employee_type',20);
            $table->boolean('staff_type_id')->default(0);
            $table->bigInteger('staff_category_id')->comment('0 - PERMANENT, 1 - CONTRACT')->index();
            $table->integer('contractor_agency_id')->nullable();
            $table->bigInteger('shift_type_id')->index();
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->bigInteger('pf_number')->nullable()->unique();
            $table->bigInteger('esic_number')->nullable()->unique();
            $table->bigInteger('uan_number')->nullable()->unique();
            $table->string('leave_approvers',50);
            $table->boolean('weekly_off')->default(1)->nullable();
            $table->string('employee_document_type',50)->nullable();
            $table->dateTime('employee_document_expires')->nullable();
            $table->string('employee_document_file',100)->nullable();
            $table->integer('created_by');
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
        Schema::dropIfExists('employee_works');
    }
};
