<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatementSendDateField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('statement', function (Blueprint $table) {
            $table->dateTime('send_date_time', $precision = 0)->default('1970-01-01 00:00:00');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('statement', function (Blueprint $table) {
            $table->dropColumn('send_date_time');
        });
    }
}
