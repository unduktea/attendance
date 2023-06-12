<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emp', function (Blueprint $table) {
            $table->string('empid', 15)->primary();
            $table->string('empname', 100);
            $table->string('gender', 1);
            $table->dateTime('birthdate');
            $table->string('placeofbirth', 50);
            $table->string('atasan1', 15);
            $table->string('atasan2', 15);
            $table->string('atasan3', 15);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp');
    }
};
