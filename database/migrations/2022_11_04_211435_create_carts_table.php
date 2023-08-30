<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index('carts_product_id_foreign');
            $table->string('order_number')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->double('price', 11, 2);
            $table->double('amount', 11, 2)->nullable();
            $table->double('bonus', 11, 2)->nullable();
            $table->enum('status', ['new', 'progress', 'delivered', 'cancel'])->default('new');
            $table->integer('quantity');
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
        Schema::dropIfExists('carts');
    }
}
