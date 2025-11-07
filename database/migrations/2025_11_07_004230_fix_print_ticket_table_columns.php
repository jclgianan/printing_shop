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
        // If the old table with camelCase name exists, rename it to snake_case
        if (Schema::hasTable('printTicket')) {
            Schema::rename('printTicket', 'print_tickets');
        }

        if (!Schema::hasTable('print_tickets')) {
            return;
        }

        // Add any missing columns safely
        if (!Schema::hasColumn('print_tickets', 'name')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->string('name')->nullable();
            });
        }

        if (!Schema::hasColumn('print_tickets', 'office_department')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->string('office_department')->nullable();
            });
        }

        if (!Schema::hasColumn('print_tickets', 'itemname')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->string('itemname')->nullable();
            });
        }

        if (!Schema::hasColumn('print_tickets', 'size')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->string('size')->nullable();
            });
        }

        if (!Schema::hasColumn('print_tickets', 'quantity')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->integer('quantity')->default(1);
            });
        }

        if (!Schema::hasColumn('print_tickets', 'release_date')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->enum('release_date')->nullable();
            });
        }

        if (!Schema::hasColumn('print_tickets', 'status')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            });
        }
        

        if (!Schema::hasColumn('print_tickets', 'process_id')) {
            Schema::table('print_tickets', function (Blueprint $table) {
                $table->foreignId('process_id')->nullable()->constrained('processes')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Try to reverse the rename and drop the added columns if possible.
        if (Schema::hasTable('print_tickets')) {
            // Attempt to drop added columns safely
            Schema::table('print_tickets', function (Blueprint $table) {
                if (Schema::hasColumn('print_tickets', 'process_id')) {
                    $table->dropForeign([$table->getConnection()->getDoctrineSchemaManager() ? 'process_id' : 'process_id']);
                }
            });

            // Rename back to original name if desired
            if (!Schema::hasTable('printTicket')) {
                Schema::rename('print_tickets', 'printTicket');
            }
        }
    }
};
