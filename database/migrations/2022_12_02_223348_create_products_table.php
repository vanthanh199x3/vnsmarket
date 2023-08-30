<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('description')->nullable();
            $table->string('link_tiktok', 500)->nullable();
            $table->string('link_youtube', 500)->nullable();
            $table->string('link_facebook', 500)->nullable();
            $table->text('photo');
            $table->integer('stock')->default(1);
            $table->string('size')->nullable()->default('M');
            $table->enum('condition', ['default', 'new', 'hot'])->default('default');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->double('price', 11, 2)->default(1);
            $table->double('import_price', 11, 2)->nullable();
            $table->double('discount', 11, 2)->nullable();
            $table->boolean('is_featured');
            $table->unsignedBigInteger('cat_id')->nullable()->index('products_cat_id_foreign');
            $table->unsignedBigInteger('child_cat_id')->nullable()->index('products_child_cat_id_foreign');
            $table->unsignedBigInteger('brand_id')->nullable()->index('products_brand_id_foreign');
            $table->integer('unit_id')->nullable();
            $table->double('price_token', 11, 2)->nullable();
            $table->double('free_token', 11, 2)->nullable();
            $table->boolean('price_token_unit');
            $table->string('wallet_address', 255)->nullable();
            $table->boolean('is_import')->nullable()->default(false);
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
        Schema::dropIfExists('products');
    }
}
