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
        // Only create the table if it doesn't already exist (safe for environments with partial state)
        if (!Schema::hasTable('print_tickets')) {
            Schema::create('print_tickets', function (Blueprint $table) {
                $table->id();
                // Optional relation to a Process record
                // Use unsignedBigInteger if the referenced table might be created later; add FK if possible
                $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
                $table->string('printTicket_id')->unique();
                $table->date('receiving_date');
                $table->string('name');
                $table->string('office_department');
                $table->string('itemname');
                $table->string('size');
                $table->integer('quantity');
                $table->date('release_date')->nullable();
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled', 'released'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('print_tickets');
    }
};
