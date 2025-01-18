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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->enum('sex', ['male', 'female']);
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('address', 50);
            $table->string('address2', 50)->nullable();
            $table->string('city', 50);
            $table->string('postcode', 20);
            $table->string('phone_no', 20);
            $table->timestamps();

            $table->index('phone_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
