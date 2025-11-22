<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'NAME') && ! Schema::hasColumn('users', 'name')) {
                $table->renameColumn('NAME', 'name');
            }

            if (Schema::hasColumn('users', 'PASSWORD') && ! Schema::hasColumn('users', 'password')) {
                $table->renameColumn('PASSWORD', 'password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'name') && ! Schema::hasColumn('users', 'NAME')) {
                $table->renameColumn('name', 'NAME');
            }

            if (Schema::hasColumn('users', 'password') && ! Schema::hasColumn('users', 'PASSWORD')) {
                $table->renameColumn('password', 'PASSWORD');
            }
        });
    }
};
