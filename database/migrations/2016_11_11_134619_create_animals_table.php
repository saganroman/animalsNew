<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimalsTable extends Migration
{
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('species_id');
            $table->integer('breed_id');
            $table->string('content');
            $table->string('photo');
            $table->string('address');
            $table->string('LatLn');
        });
    }


    public function down()
    {
        Schema::drop('animals');
    }

}
