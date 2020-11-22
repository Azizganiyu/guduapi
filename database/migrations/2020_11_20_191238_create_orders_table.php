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
            $table->id();
            $table->string('address');
            $table->string('state');
            $table->string('city');
            $table->string('phone');
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('cart');
            $table->integer('delivery_fee');
            $table->string('delivery_type');
            $table->integer('total_price');
            $table->string('delivery_time_min');
            $table->string('delivery_time_max');
            $table->string('payment_type');
            $table->integer('payment_status');
            $table->string('delivery_status')->default('pending');
            $table->string('order_status')->default('pending');
            $table->string('order_code');
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
        Schema::dropIfExists('orders');
    }
}
