<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('category_id');
            $table->Integer('sub_category_id');
            $table->String('item_name');
            $table->mediumText('item_image');
            $table->mediumText('description')->nullable();
            $table->double('price');
            $table->double('tax')->nullable();
            $table->Integer('unit_measure_id');
            $table->double('stock_qty');
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
        Schema::dropIfExists('food_items');
    }
}
