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
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            
            // Device Identification
            $table->string('device_id'); // Unique identifier for individual device
            $table->string('individual_id')->unique();
            $table->string('device_name'); // e.g., "Dell Laptop", "HP Monitor"
            $table->string('category'); // Computer system, Components, Peripherals, etc.
            $table->string('serial_number')->nullable();
            
            // Specifications (for PCs)
            $table->string('processor')->nullable();
            $table->string('ram')->nullable();
            $table->string('storage')->nullable();
            $table->string('graphics_card')->nullable();
            $table->text('other_specs')->nullable();

            $table->integer('quantity')->default(1);
            
            // Status and Condition
            $table->enum('status', ['available', 'issued', 'unusable'])->default('available');
            $table->enum('condition', ['new', 'good', 'fair', 'poor'])->default('good');
            
            // Assignment Information
            $table->string('issued_to')->nullable();
            $table->string('office')->nullable();
            
            // Dates
            $table->date('date_acquired')->nullable();
            $table->date('date_issued')->nullable();
            
            // Additional Info
            $table->text('notes')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};