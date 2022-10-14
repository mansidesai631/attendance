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
        Schema::table('employees', function (Blueprint $table) {
            $table->bigInteger('parent_id')->nullable()->after('id');
            $table->bigInteger('role_id')->after('parent_id');
            $table->enum('user_type', ['Admin', 'Staff', 'Subadmin'])->default('Staff')->after('role_id');
            $table->string('country_code',55)->default(91)->after('password');
            $table->string('mobile',15)->unique()->after('name');
            $table->date('dob')->after('country_code');
            $table->string('blood_group',3)->nullable()->after('dob');
            $table->string('id_type',20)->nullable()->after('blood_group');
            $table->string('id_number',20)->nullable()->after('id_type');
            $table->enum('gender', ['Male', 'Female', 'Other'])->after('id_number');
            $table->string('image',50)->nullable()->after('gender');
            $table->boolean('status')->default(1)->index()->after('image');
            $table->enum('added_from', ['Sheet', 'Normal'])->default('Normal')->after('status');
            $table->boolean('invite_sent')->default(1)->after('added_from');
            $table->integer('created_by')->after('invite_sent');
            $table->integer('updated_by')->nullable()->after('created_by');
            $table->integer('deleted_by')->nullable()->after('updated_by');
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
        Schema::table('employees', function (Blueprint $table) {
            //
        });
    }
};
