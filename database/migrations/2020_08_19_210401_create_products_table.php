<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('short_description')->nullable();
            $table->unsignedDecimal('price', 12, 2)->nullable();
            $table->unsignedDecimal('base_price', 12, 2)->default(0)->nullable();
            $table->unsignedDecimal('unit_price', 12, 2)->default(0)->nullable();
            $table->integer('base_category')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('sort')->default(0);
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
        Schema::dropIfExists('products');
    }
}
