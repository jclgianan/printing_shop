<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('repair_tickets', function (Blueprint $table) {
            $table->dateTime('release_date')->nullable()->change();
        });
        
        Schema::table('print_tickets', function (Blueprint $table) {
            $table->dateTime('release_date')->nullable()->change();
        }); 
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repair_tickets', function (Blueprint $table) {
            //
        });
    }
};
