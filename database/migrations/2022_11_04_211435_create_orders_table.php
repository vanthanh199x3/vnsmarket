<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id')->nullable();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('user_id')->nullable()->index('orders_user_id_foreign');
            $table->double('sub_total', 11, 2);
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->double('coupon', 11, 2)->nullable();
            $table->double('total_amount', 11, 2);
            $table->integer('quantity');
            $table->string('payment_method', 20)->default('cod');
            $table->enum('payment_status', ['paid', 'unpaid'])->default('unpaid');
            $table->integer('bonus_status')->nullable();
            $table->enum('status', ['new', 'process', 'delivered', 'cancel'])->default('new');
            $table->string('full_name');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('country')->nullable();
            $table->string('province_id')->nullable();
            $table->string('post_code')->nullable();
            $table->text('address1');
            $table->text('address2')->nullable();
            $table->timestamps();
            $table->boolean('is_delete')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
