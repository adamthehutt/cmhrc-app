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
        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignIdFor(\App\Models\User::class);
            $table->string("avatar");
            $table->date("dob");
            $table->enum("sex", ["Male", "Female", "Other"]);
            $table->enum("gender", ["Male", "Female", "Nonbinary"]);
            $table->json("symptoms")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
