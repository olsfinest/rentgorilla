<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeatRentalTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('heat_rental', function(Blueprint $table)
        {
            $table->integer('rental_id')->unsigned()->index();
            $table->integer('heat_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('rental_id')
                ->references('id')
                ->on('rentals')
                ->onDelete('cascade');

            $table->foreign('heat_id')
                ->references('id')
                ->on('heats')
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
        Schema::drop('heat_rental');
	}

}
