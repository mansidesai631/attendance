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
        Schema::create('m_challans', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('concern_officer');
            $table->integer('department')->nullable();
            $table->string('name_of_citizen',50)->nullable();
            $table->string('mobile',50)->nullable();
            $table->string('id_type',50)->nullable();
            $table->string('id_number',25)->nullable();
            $table->text('description')->nullable();
            $table->string('amount_of_fine',25)->nullable();
            $table->string('address',255)->nullable();
            $table->string('image',255)->nullable();
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
        Schema::dropIfExists('m_challans');
    }
};
