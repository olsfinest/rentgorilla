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
            $table->string('uuid')->index();
            $table->unsignedInteger('location_id');
			$table->unsignedInteger('user_id');
            $table->boolean('active')->default(0);
            $table->boolean('promoted')->default(0);
            $table->boolean('queued')->default(0);
			$table->enum('type', ['house', 'apartment', 'room', 'commercial']);
		    $table->string('street_address');
            $table->string('postal_code')->nullable();
            $table->float('lat', 10, 6);
            $table->float('lng', 10, 6);
			$table->integer('beds');
            $table->decimal('baths', 2, 1);
            $table->integer('price');
            $table->integer('deposit');
            $table->integer('lease');
            $table->integer('square_footage');
            $table->enum('laundry', ['none', 'unit_free', 'unit_coin', 'shared_coin', 'shared_free']);
            $table->enum('pets', ['none', 'any', 'cats_dogs', 'cats', 'dogs']);
            $table->enum('parking', ['none', 'driveway', 'underground', 'garage', 'street']);
            $table->text('description')->nullable();
            $table->timestamp('available_at');
            $table->timestamp('promotion_ends_at')->nullable();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('edited_at')->nullable();
            $table->timestamp('queued_at')->nullable();
            $table->boolean('disability_access');
            $table->boolean('smoking');
            $table->boolean('utilities_included');
            $table->boolean('heat_included');
            $table->boolean('furnished');
            $table->string('video')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->unsignedInteger('search_views')->default(0);
            $table->unsignedInteger('email_click')->default(0);
            $table->unsignedInteger('phone_click')->default(0);

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
