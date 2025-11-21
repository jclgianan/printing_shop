<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('repair_tickets', function (Blueprint $table) {
            // Add column BEFORE repairTicket_id by placing AFTER process_id
            $table->text('repairDevice_id')->nullable()->after('process_id');
        });
    }

    public function down()
    {
        Schema::table('repair_tickets', function (Blueprint $table) {
            $table->dropColumn('repairDevice_id');
        });
    }
};
