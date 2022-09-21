<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index(['slug', 'price', 'title', 'category_id'], 'idx-product-fields');
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->index(['title', 'slug', 'parent_id'], 'idx-category-fields');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            if ($table->hasIndex('idx-category-fields')) {
                $table->dropIndex('idx-category-fields');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if ($table->hasIndex('idx-product-fields')) {
                $table->dropIndex('idx-product-fields');
            }
        });
    }
};
