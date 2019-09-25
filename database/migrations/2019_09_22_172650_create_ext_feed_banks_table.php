<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtFeedBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ext_feed_banks', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->integer('user_id')->nullable();
          $table->string('site')->nullable();
          $table->string('site_image')->nullable();
          $table->longText('title');
          $table->longText('des');
          $table->string('link');
          $table->string('date');
          $table->longText('image')->nullable();
          $table->timestamps();
          $table->string('tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ext_feed_banks');
    }
}
