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
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable();
            }

            if (! Schema::hasColumn('products', 'cut_type')) {
                $table->string('cut_type')->nullable();
            }

            if (! Schema::hasColumn('products', 'discount')) {
                $table->decimal('discount', 10, 2)->default(0);
            }

            if (! Schema::hasColumn('products', 'weight')) {
                $table->decimal('weight', 10, 2)->default(0);
            }

            if (! Schema::hasColumn('products', 'halal_certified')) {
                $table->boolean('halal_certified')->default(false);
            }

            if (! Schema::hasColumn('products', 'weight_variant')) {
                $table->string('weight_variant')->nullable();
            }

            if (! Schema::hasColumn('products', 'cooking_tips')) {
                $table->text('cooking_tips')->nullable();
            }

            if (! Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'cut_type')) {
                $table->dropColumn('cut_type');
            }

            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('products', 'discount')) {
                $table->dropColumn('discount');
            }

            if (Schema::hasColumn('products', 'weight')) {
                $table->dropColumn('weight');
            }

            if (Schema::hasColumn('products', 'halal_certified')) {
                $table->dropColumn('halal_certified');
            }

            if (Schema::hasColumn('products', 'weight_variant')) {
                $table->dropColumn('weight_variant');
            }

            if (Schema::hasColumn('products', 'cooking_tips')) {
                $table->dropColumn('cooking_tips');
            }

            if (Schema::hasColumn('products', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
