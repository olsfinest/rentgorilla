<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFreePromotionToRentals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->boolean('free_promotion')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rentals', function (Blueprint $table) {
            $table->dropColumn('free_promotion');
        });
    }
}
