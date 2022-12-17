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
        Schema::create('symptom_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid("profile_id");
            $table->string("symptom");
            $table->date("date");
            $table->unsignedTinyInteger("rating");
            $table->timestamps();

            $table->unique(["profile_id", "date", "symptom"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('symptom_reports');
    }
};
