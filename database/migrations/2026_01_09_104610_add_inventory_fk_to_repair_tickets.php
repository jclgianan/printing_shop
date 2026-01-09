<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
            $table->dropForeign(['inventory_id']);
        });
    }
};
