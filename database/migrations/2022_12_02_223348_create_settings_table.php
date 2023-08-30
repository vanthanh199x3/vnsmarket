<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id')->nullable();
            $table->longText('description');
            $table->text('short_des');
            $table->string('logo');
            $table->string('photo');
            $table->string('shortcut')->nullable();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->text('youtube_video')->nullable();
            $table->text('google_iframe')->nullable();
            $table->string('facebook', 255)->nullable();
            $table->string('zalo', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('tiktok', 255)->nullable();
            $table->timestamps();
            $table->integer('default_wallet')->nullable();
            $table->integer('default_bank')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
