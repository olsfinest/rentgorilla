<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rentals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('user_id');
            $table->boolean('active')->default(0);
			$table->enum('type', ['house', 'apartment', 'room']);
			$table->enum('province', ['AB', 'BC', 'MB', 'NB', 'NL', 'NT', 'NS', 'NU', 'ON', 'PE', 'QC', 'SK', 'YT']);
			$table->string('city');
			$table->string('street_address');
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
			$table->integer('beds');
			$table->integer('price');
			$table->timestamp('available_at');
			$table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
		Schema::drop('rentals');
	}

}
