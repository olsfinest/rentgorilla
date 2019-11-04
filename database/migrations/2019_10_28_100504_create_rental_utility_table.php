<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalUtilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_utility', function(Blueprint $table)
		{
		$table->integer('rental_id')->unsigned()->index();
		$table->integer('utility_id')->unsigned()->index();
		$table->timestamps();

		$table->foreign('rental_id')
		->references('id')
		->on('rentals')
		->onDelete('cascade');

		$table->foreign('utility_id')
		->references('id')
		->on('utilities')
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
        Schema::drop('rental_utility');
    }
}
