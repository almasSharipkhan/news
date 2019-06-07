<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsHeadings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_headings', function (Blueprint $table) {
            $table->integerIncrements('news_headings_id');
            $table->integer('news_id')->unsigned();
            $table->integer('heading_id')->unsigned();
            $table->foreign('news_id')->references('news_id')->on('news');
            $table->foreign('heading_id')->references('heading_id')->on('headings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_headings');
    }
}
