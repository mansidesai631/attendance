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
        Schema::create('employee_others', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('employee_id');
            $table->string('bank_name',50)->nullable();
            $table->string('account_name',50)->nullable();
            $table->string('account_number',50)->unique()->nullable();
            $table->enum('account_type', ['Current', 'Savings']);
            $table->bigInteger('ifsc_code')->nullable();
            $table->bigInteger('micr_code')->nullable();
            $table->bigInteger('swift_code')->nullable();
            $table->string('father_name',20);
            $table->string('permanent_address',50);
            $table->string('communication_address',50);
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
        Schema::dropIfExists('employee_others');
    }
};
