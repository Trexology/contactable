<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

    public function up()
    {
        Schema::create('addresses', function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->morphs('addressable');

            $table->string('block')->nullable();
            $table->string('unit')->nullable();

            $table->string('street')->nullable();
            $table->string('street_extra')->nullable();

            $table->string('country')->default('singapore');
            $table->string('country_code', 2)->default('sg');
            $table->string('city')->nullable();
            $table->string('subdivision')->nullable();

            $table->string('postal_code')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('long', 10, 7)->nullable();

            $table->smallInteger('position')->unsigned();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('addresses');
    }
}
