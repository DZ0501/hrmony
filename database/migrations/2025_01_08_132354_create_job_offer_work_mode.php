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
        Schema::create('job_offer_work_mode', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_offer_id')->constrained()->onDelete('cascade');
            $table->foreignId('work_mode_id')->constrained('work_modes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_offer_work_mode');
    }
};
