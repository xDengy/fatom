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
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedInteger('position')->default(10)->comment('Позиция');
            $table->string('seo_title')->nullable();
            $table->string('seo_h1')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('description')->nullable();
            $table->text('keywords')->nullable();
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
            $table->dropColumn(
                ['seo_description', 'description', 'seo_h1', 'seo_title', 'keywords', 'position']
            );
        });
    }
};
