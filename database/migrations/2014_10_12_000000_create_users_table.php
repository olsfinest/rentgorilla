<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('points')->default(0);
            $table->boolean('is_admin')->default(0);
			$table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
			$table->string('password', 60)->nullable();
            $table->string('confirmation')->nullable();
            $table->tinyInteger('confirmed')->default(0);
            $table->boolean('monthly_emails')->default(1);
            $table->enum('provider', ['email', 'facebook', 'google']);
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
         	$table->rememberToken();
            $table->timestamp('current_period_end')->nullable();
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
		Schema::drop('users');
	}

}
