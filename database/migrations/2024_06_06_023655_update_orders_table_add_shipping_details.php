<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableAddShippingDetails extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('address')->after('total_price');
            $table->string('city')->after('address');
            $table->string('postal_code')->after('city');
            $table->string('country')->after('postal_code');
            $table->string('phone')->after('country');
            $table->string('shipping_method')->after('phone');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropColumn('country');
            $table->dropColumn('phone');
            $table->dropColumn('shipping_method');
        });
    }
}
