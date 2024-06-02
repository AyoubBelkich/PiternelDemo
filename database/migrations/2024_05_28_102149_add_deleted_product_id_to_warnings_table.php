<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeletedProductIdToWarningsTable extends Migration
{
    public function up()
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->foreignId('deleted_product_id')->nullable()->constrained('deleted_products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->dropForeign(['deleted_product_id']);
            $table->dropColumn('deleted_product_id');
        });
    }
}
