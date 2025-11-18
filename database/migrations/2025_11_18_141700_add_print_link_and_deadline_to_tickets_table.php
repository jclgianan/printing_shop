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
        Schema::table('print_tickets', function (Blueprint $table) {
            $table->string('file_link')->nullable();   // link to the file
            $table->dateTime('deadline')->nullable();   // deadline datetime
        });
    }

    public function down()
    {
        Schema::table('print_tickets', function (Blueprint $table) {
            $table->dropColumn(['file_link', 'deadline']);
        });
    }

};
