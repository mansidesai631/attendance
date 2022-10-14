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
        Schema::create('field_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('title',55);
            $table->string('zone',55);
            $table->string('circle',55);
            $table->string('officer',55);
            $table->string('department',55)->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('field_monitorings');
    }
};
