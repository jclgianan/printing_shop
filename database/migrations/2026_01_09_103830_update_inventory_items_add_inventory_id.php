<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {

            // Add inventory_id only if it does NOT exist
            if (!Schema::hasColumn('inventory_items', 'inventory_id')) {
                $table->string('inventory_id', 255)
                    ->unique()
                    ->collation('utf8mb4_unicode_ci')
                    ->after('id');
            }

            // Drop old identifiers only if they exist
            if (Schema::hasColumn('inventory_items', 'device_id')) {
                $table->dropColumn('device_id');
            }

            if (Schema::hasColumn('inventory_items', 'quantity')) {
                $table->dropColumn('quantity');
            }

            if (Schema::hasColumn('inventory_items', 'individual_id')) {
                $table->dropColumn('individual_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('inventory_items', function (Blueprint $table) {

            // Restore dropped columns
            if (!Schema::hasColumn('inventory_items', 'device_id')) {
                $table->string('device_id')->nullable();
            }

            if (!Schema::hasColumn('inventory_items', 'quantity')) {
                $table->integer('quantity')->default(1);
            }

            if (!Schema::hasColumn('inventory_items', 'individual_id')) {
                $table->string('individual_id')->unique()->nullable();
            }

            // Remove inventory_id
            if (Schema::hasColumn('inventory_items', 'inventory_id')) {
                $table->dropColumn('inventory_id');
            }
        });
    }
};
