<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employment_type_job_offer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employment_type_id')->constrained('employment_types')->onDelete('cascade');
            $table->foreignId('job_offer_id')->constrained('job_offers')->onDelete('cascade');

            $table->unique(['employment_type_id', 'job_offer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employment_type_job_offer');
    }
};
