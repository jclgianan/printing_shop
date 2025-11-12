<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create table if it doesn't exist
        if (!Schema::hasTable('print_tickets')) {
            Schema::create('print_tickets', function (Blueprint $table) {
                $table->id();
                $table->string('repairTicket_id')->unique();
                $table->string('name')->nullable();
                $table->string('office_department')->nullable();
                $table->string('itemname')->nullable();
                $table->string('size')->nullable();
                $table->integer('quantity')->default(1);
                $table->date('release_date')->nullable();
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
                $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
                $table->timestamps();
            });

            return; // Table created, no need to run fixes
        }

        // Rename old table if it exists
        if (Schema::hasTable('printTicket')) {
            Schema::rename('printTicket', 'print_tickets');
        }

        // Add missing columns safely
        Schema::table('print_tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('print_tickets', 'name')) $table->string('name')->nullable();
            if (!Schema::hasColumn('print_tickets', 'office_department')) $table->string('office_department')->nullable();
            if (!Schema::hasColumn('print_tickets', 'itemname')) $table->string('itemname')->nullable();
            if (!Schema::hasColumn('print_tickets', 'size')) $table->string('size')->nullable();
            if (!Schema::hasColumn('print_tickets', 'quantity')) $table->integer('quantity')->default(1);
            if (!Schema::hasColumn('print_tickets', 'release_date')) $table->date('release_date')->nullable();
            if (!Schema::hasColumn('print_tickets', 'status')) $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            if (!Schema::hasColumn('print_tickets', 'process_id')) $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('print_tickets')) {
            Schema::dropIfExists('print_tickets');
        }
    }
};
