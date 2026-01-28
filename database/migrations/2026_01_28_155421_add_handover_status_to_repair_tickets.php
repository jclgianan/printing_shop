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
        Schema::table('repair_tickets', function (Blueprint $table) {
            // We set the default to 'in_office'
            $table->string('handover_status')->default('in_office')->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('repair_tickets', function (Blueprint $table) {
            $table->dropColumn('handover_status');
        });
    }
};
