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
            $table->string('name');
            $table->integer('product_category_id');
            $table->dateTime('manufacturing_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->boolean('is_active')->nullable();
            $table->text('description')->nullable();
            $table->decimal('buying_price')->nullable();
            $table->decimal('selling_price')->nullable();
            $table->bigInteger('stock_id')->unsigned();
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
