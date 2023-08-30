<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->foreign(['cart_id'], 'wishlists_ibfk_1')->references(['id'])->on('carts')->onDelete('SET NULL');
            $table->foreign(['product_id'], 'wishlists_ibfk_2')->references(['id'])->on('products')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropForeign('wishlists_ibfk_1');
            $table->dropForeign('wishlists_ibfk_2');
        });
    }
}
