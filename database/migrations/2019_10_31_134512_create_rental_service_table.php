<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRentalServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_service', function (Blueprint $table) {
            $table->integer('rental_id')->unsigned()->index();
			$table->integer('service_id')->unsigned()->index();
			$table->timestamps();

			$table->foreign('rental_id')
			->references('id')
			->on('rentals')
			->onDelete('cascade');

			$table->foreign('service_id')
			->references('id')
			->on('services')
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
        Schema::drop('rental_service');
    }
}
