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
        Schema::create('cutis', function (Blueprint $table) {
            $table->id();
            $table->string('empid', 15);
            $table->string('tgl_mulai', 20);
            $table->string('tgl_selesai', 20);
            $table->string('alasan', 255);
            $table->boolean('acc1')->default(false);
            $table->boolean('acc2')->default(false);
            $table->boolean('acc3')->default(false);
            $table->string('disetujui1', 15)->nullable();
            $table->string('disetujui2', 15)->nullable();
            $table->string('disetujui3', 15)->nullable();
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutis');
    }
};
