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
        Schema::create('leave_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('leave_type_id');
            $table->bigInteger('employee_id');
            $table->date('start_date')->nullable();
            $table->enum('start_leave_period', ['FULL DAY', 'FIRST HALF', 'SECOND HALF'])->nullable();
            $table->date('end_date')->nullable();
            $table->enum('end_leave_period', ['FULL DAY', 'FIRST HALF', 'SECOND HALF'])->nullable();
            $table->string('attachment',255)->nullable();
            $table->string('leave_applied_reason',150)->nullable();
            $table->string('leave_denied_reason',150)->nullable();
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED','ALLOTED','CANCELLED']);
            $table->integer('status_changed_by')->nullable();
            $table->float('tota_days',10,2);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('cancelled_by')->nullable();
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
        Schema::dropIfExists('leave_lists');
    }
};
