<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if the indexes already exist before adding them
            if (!Schema::hasIndex('users', 'users_name_index')) {
                $table->index('name', 'users_name_index');
            }
            if (!Schema::hasIndex('users', 'users_email_index')) {
                $table->index('email', 'users_email_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the indexes if they exist
            $table->dropIndex('users_name_index');
            $table->dropIndex('users_email_index');
        });
    }
};
