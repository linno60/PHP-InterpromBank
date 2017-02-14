<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('year');
            $table->string('code');
            $table->string('season_code');
            $table->integer('season_number');
            $table->text('url');
            $table->text('image');
            $table->text('description');
            $table->string('playlist_url')->nullable();
            $table->integer('episodes_count');
            $table->integer('movie_id')->unsigned();
            $table->foreign('movie_id')
                  ->references('id')->on('movies')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('seasons');
    }
}
