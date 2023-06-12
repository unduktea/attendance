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
        Schema::create('lemburs', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 15);
            $table->string('tanggal', 10);
            $table->string('shift', 10);
            $table->integer('over_before');
            $table->integer('over_after');
            $table->integer('break_before');
            $table->integer('break_after');
            $table->string('kompensation', 20);
            $table->string('reason', 255);
            $table->string('status', 15);
            $table->timestamps();
            $table->unique(array('empid', 'tanggal', 'status'), 'unique_attendance');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lemburs');
    }
};
