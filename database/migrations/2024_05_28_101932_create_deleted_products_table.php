<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedProductsTable extends Migration
{
    public function up()
    {
        Schema::create('deleted_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->text('description');
            $table->integer('product_type');
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('price_per_day', 8, 2)->nullable();
            $table->date('available_from')->nullable();
            $table->date('available_to')->nullable();
            $table->integer('stock_quantity');
            $table->string('image')->nullable();
            $table->boolean('rental_available')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deleted_products');
    }
}
