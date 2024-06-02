<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRentalFieldsToProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('price_per_day', 10, 2)->nullable()->after('price');
            $table->date('available_from')->nullable()->after('price_per_day');
            $table->date('available_to')->nullable()->after('available_from');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_per_day', 'available_from', 'available_to']);
        });
    }
}
