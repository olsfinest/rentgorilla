<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slides', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('landing_page_id')->unsigned();
            $table->string('name');
            $table->string('alt')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();

            $table->foreign('landing_page_id')
                ->references('id')
                ->on('landing_pages')
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
        Schema::drop('slides');
    }
}
