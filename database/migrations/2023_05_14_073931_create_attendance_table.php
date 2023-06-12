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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 15);
            $table->dateTime('attdate');
            $table->string('shiftid', 20)->nullable();
            $table->dateTime('actualin')->nullable();
            $table->dateTime('actualout')->nullable();
            $table->float('late')->nullable();
            $table->float('early')->nullable();
            $table->float('ottotal')->nullable();
            $table->string('notes', 2000)->nullable();
            $table->dateTime('inputdate')->nullable();
            $table->dateTime('editdate')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('markas', 100)->nullable();
            $table->float('suhu');
            $table->unique(array('empid', 'attdate'), 'unique_attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
