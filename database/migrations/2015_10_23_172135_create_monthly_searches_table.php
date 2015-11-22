<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMonthlySearchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monthly_searches', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('location_id');
            $table->unsignedSmallInteger('year');
            $table->unsignedSmallInteger('month');
            $table->unsignedInteger('searches');
            $table->timestamps();

            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
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
        Schema::drop('monthly_searches');
    }
}
