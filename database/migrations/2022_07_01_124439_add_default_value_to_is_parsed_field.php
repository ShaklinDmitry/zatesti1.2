<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultValueToIsParsedField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_for_the_text_that_will_be_parsed_into_statements', function (Blueprint $table) {
            $table->integer('is_parsed')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_for_the_text_that_will_be_parsed_into_statements', function (Blueprint $table) {
            //
        });
    }
}
