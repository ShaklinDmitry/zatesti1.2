<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_for_the_text_that_will_be_parsed_into_statements', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->unsigned()->default(NULL);
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
            $table->dropColumn('user_id');
        });
    }
};
