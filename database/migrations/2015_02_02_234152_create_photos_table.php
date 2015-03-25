<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('photos', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('rental_id')->unsigned();
            $table->string('name');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('rental_id')
                ->references('id')
                ->on('rentals')
                ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('photos');
	}

}
