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
        if (!Schema::hasTable('repair_tickets')) {
            Schema::create('repair_tickets', function (Blueprint $table) {
                $table->id();
                // Optional relation to a Process record
                // Use unsignedBigInteger if the referenced table might be created later; add FK if possible
                $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
                $table->string('repairTicket_id')->unique();
                $table->date('receiving_date');
                $table->string('name');
                $table->string('office_department');
                $table->string('itemname');
                $table->string('issue');
                $table->string('note')->nullable();
                $table->date('release_date')->nullable();
                $table->enum('status', ['pending', 'in_progress', 'repaired', 'unrepairable', 'released'])->default('pending');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    Schema::dropIfExists('repair_tickets');
    }
};
