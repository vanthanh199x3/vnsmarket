<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->foreign(['product_id'], 'product_reviews_ibfk_1')->references(['id'])->on('products')->onDelete('SET NULL');
            $table->foreign(['user_id'], 'product_reviews_ibfk_2')->references(['id'])->on('users')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropForeign('product_reviews_ibfk_1');
            $table->dropForeign('product_reviews_ibfk_2');
        });
    }
}
