<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('email_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('address')->unique();

            $table->morphs('emailable');

            $table->smallInteger('position')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('email_addresses');
    }
}
