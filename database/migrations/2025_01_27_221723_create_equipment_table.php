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
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('equipment_type_id')->nullable()->constrained('equipment_types')->onDelete('set null');
            $table->string('serial_number')->unique();
            $table->enum('status', ['available', 'assigned', 'under_maintenance', 'retired'])->default('available');
            $table->date('purchase_date')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->date('warranty_until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipment', function (Blueprint $table) {
            $table->dropForeign(['equipment_type_id']);
            $table->dropColumn('equipment_type_id');
        });

        Schema::dropIfExists('equipment_types');
    }
};
