<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableForTheTextThatWillBeParsedIntoStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_for_the_text_that_will_be_parsed_into_statements', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->boolean('is_parsed');
            $table->dateTime('parsed_date_time', $precision = 0)->default('1970-01-01 00:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_for_the_text_that_will_be_parsed_into_statements');
    }
}
