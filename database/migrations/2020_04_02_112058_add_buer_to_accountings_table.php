<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBuerToAccountingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accountings', function (Blueprint $table) {
            $table->unsignedBigInteger('buer_id')->nullable();
            $table->integer('sell_price')->nullable();
            $table->date('sell_date')->nullable();

            $table->foreign('buer_id')->references('id')->on('buers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('accountings', function (Blueprint $table) {

            $table->dropForeign('accountingss_buer_id_foreign');
            $table->dropColumn('buer_id', 'sell_price', 'sell_date');
        });
    }
}
