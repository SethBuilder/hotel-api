<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('rating')->unsigned();
            $table->string('category');
            $table->string('image');
            $table->integer('reputation')->unsigned();
            $table->integer('price');
            $table->integer('availability');

            $table->integer('location_id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations');

            $table->integer('hotelier_id')->unsigned();
            $table->foreign('hotelier_id')->references('id')->on('hoteliers');

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
        Schema::dropIfExists('items');
    }
}
