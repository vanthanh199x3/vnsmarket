<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable();
            $table->string('shop_name', 200)->nullable();
            $table->string('shop_domain', 200)->nullable();
            $table->string('base_domain', 20)->nullable();
            $table->string('shop_phone', 20)->nullable();
            $table->string('shop_address', 255)->nullable();
            $table->boolean('status')->nullable()->default(false);
            $table->text('env')->nullable();
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
        Schema::dropIfExists('shops');
    }
}
