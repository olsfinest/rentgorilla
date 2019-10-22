<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalSafetyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('rental_safety', function(Blueprint $table)
		{
		$table->integer('rental_id')->unsigned()->index();
		$table->integer('safety_id')->unsigned()->index();
		$table->timestamps();

		$table->foreign('rental_id')
		->references('id')
		->on('rentals')
		->onDelete('cascade');

		$table->foreign('safety_id')
		->references('id')
		->on('safeties')
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
        Schema::drop('rental_safety');
    }
}
