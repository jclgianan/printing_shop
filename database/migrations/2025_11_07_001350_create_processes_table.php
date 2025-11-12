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
        if (Schema::hasTable('processes')) {
            return;
        }

        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->string('printTicket_id')->nullable();
            $table->string('repairTicket_id')->nullable();
            $table->date('receiving_date')->nullable();
            $table->enum('type', ['repair', 'printing'])->default('repair');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('processes');
    }
};
