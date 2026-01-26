<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repair_tickets', function (Blueprint $table) {

            // Add column if it doesn't exist
            if (!Schema::hasColumn('repair_tickets', 'inventory_id')) {
                $table->string('inventory_id', 255)
                    ->nullable()
                    ->collation('utf8mb4_unicode_ci')
                    ->after('repairTicket_id');

                // Add an index (required for FK)
                $table->index('inventory_id');
            }
        });

        // Add FK separately to avoid issues
        Schema::table('repair_tickets', function (Blueprint $table) {
            $table->foreign('inventory_id')
                ->references('inventory_id')
                ->on('inventory_items')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('repair_tickets', function (Blueprint $table) {
            if (Schema::hasColumn('repair_tickets', 'inventory_id')) {
                $table->dropForeign(['inventory_id']);
                $table->dropIndex(['inventory_id']);
                $table->dropColumn('inventory_id');
            }
        });
    }
};
