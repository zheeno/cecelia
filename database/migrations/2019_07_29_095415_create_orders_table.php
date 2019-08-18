<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->Integer('user_id')->nullable();
            $table->String('cart_token');

            $table->String('customer_name');
            $table->String('customer_email')->nullable();
            $table->String('phone_no');
            $table->String('country');
            $table->String('state');
            $table->String('lga')->nullable();
            $table->mediumText('address');

            $table->Float('shipping_fee');
            $table->Float('discount');
            $table->Float('cart_total');
            $table->Float('order_total');
            
            $table->String('payment_method')->nullable();
            $table->Boolean('payment_status');
            $table->String('delivery_method')->nullable();
            $table->String('delivery_status_desc')->nullable();
            $table->Boolean('delivery_status');
            $table->String('delivery_date')->nullable();

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
