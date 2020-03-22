<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->json('title');
            $table->json('body')->nullable();
            $table->json('props')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            $table->unsignedInteger('sort_order')->default(1);
            $table->timestamps();

            $table->foreign('author_id')->references('id')->on('authors')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
