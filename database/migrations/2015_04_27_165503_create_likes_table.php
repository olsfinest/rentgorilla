<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('likes', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->integer('rental_id')->unsigned()->index();
            $table->integer('photo_id')->unsigned()->index();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('rental_id')
                ->references('id')
                ->on('rentals')
                ->onDelete('cascade');

            $table->foreign('photo_id')
                ->references('id')
                ->on('photos')
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
        Schema::drop('likes');
	}

}
