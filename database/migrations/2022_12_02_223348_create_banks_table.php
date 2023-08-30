<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banks', function (Blueprint $table) {
            $table->tinyInteger('id', true);
            $table->integer('user_id')->nullable();
            $table->string('photo', 255)->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_address', 255)->nullable();
            $table->string('account_name', 255);
            $table->string('account_number', 50)->nullable();
            $table->string('note', 500)->nullable();
            $table->boolean('is_default')->default(true);
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banks');
    }
}
