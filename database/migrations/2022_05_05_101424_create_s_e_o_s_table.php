<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_e_o_s', function (Blueprint $table) {
            $table->id();
            $table->longText("page")->nullable();
            $table->longText("page_url")->nullable();
            $table->longText("h1")->nullable();
            $table->longText("title")->nullable();
            $table->longText("description")->nullable();
            $table->longText("keywords")->nullable();
            $table->longText("subtitle")->nullable();
            $table->longText("fulldesc")->nullable();
            $table->longText("phone")->nullable();
            $table->longText("email")->nullable();
            $table->longText("city")->nullable();
            $table->longText("street")->nullable();
            $table->longText("weekdays")->nullable();
            $table->longText("weekend")->nullable();
            $table->longText("link1")->nullable();
            $table->longText("link2")->nullable();
            $table->longText("link3")->nullable();
            $table->longText("doptitle1")->nullable();
            $table->longText("doptxt1")->nullable();
            $table->longText("doptitle2")->nullable();
            $table->longText("doptxt2")->nullable();
            $table->longText("doptxt3")->nullable();
            $table->longText("codkarti")->nullable();
            $table->longText("codhtml")->nullable();
            $table->longText("hero")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_e_o_s');
    }
};
