<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhoneNumbersTable extends Migration
{
    public function up()
    {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('extension')->nullable();
            $table->string('number');
            $table->string('raw_number')->unique();
            $table->string('type', 64)->nullable()->default('work');
            $table->string('country')->nullable();
            $table->string('country_code', 2)->default('sg');

            $table->morphs('phonable');

            $table->smallInteger('position')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('phone_numbers');
    }
}
