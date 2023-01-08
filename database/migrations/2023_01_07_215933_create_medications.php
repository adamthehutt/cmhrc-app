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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->uuid('profile_id')->index();
            $table->string('name');
            $table->string('frequency');
            $table->string('frequency_other')->nullable();
            $table->text('dosage');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('medication_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medication_id');
            $table->date('date');
            $table->boolean('taken');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medications');
        Schema::dropIfExists('medication_reports');
    }
};
