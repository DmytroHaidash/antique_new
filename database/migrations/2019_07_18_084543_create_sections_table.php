<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug');
            $table->json('title');
            $table->json('description')->nullable();
            $table->json('body')->nullable();
            $table->enum('type', ['exhibit', 'publication']);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedInteger('sort_order')->default(1);
            $table->string('color')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('sections')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
