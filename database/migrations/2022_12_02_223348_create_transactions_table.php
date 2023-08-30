<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('transaction_id', 50)->nullable();
            $table->dateTime('transaction_time')->nullable();
            $table->tinyInteger('transaction_type')->nullable();
            $table->string('from', 255)->nullable();
            $table->string('to', 255)->nullable();
            $table->double('money')->nullable()->default(0);
            $table->double('fee')->nullable();
            $table->tinyInteger('wallet_id')->nullable();
            $table->boolean('status')->nullable();
            $table->string('content', 255)->nullable();
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
        Schema::dropIfExists('transactions');
    }
}
