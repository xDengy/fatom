<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private static array $defaults = [
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->default('');
            $table->bigInteger('parent_id')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();
            $table->string('has_products')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(
                DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            );

            $table->charset = static::$defaults['charset'];
            $table->collation = static::$defaults['collation'];
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('keywords')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->default('');
            $table->double('price')->nullable();
            $table->string('price_title')->nullable();
            $table->string('image_path')->nullable();
            $table->string('image_alt')->nullable();
            $table->string('image_title')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->longText('options')->nullable();
            $table->longText('options_translited')->nullable();
            $table->longText('description')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

            $table->charset = static::$defaults['charset'];
            $table->collation = static::$defaults['collation'];
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
        Schema::dropIfExists('categories');
    }
};
