<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('order_items', function (Blueprint $table) {
			$table->id();
			$table->bigInteger('order_id');
			$table->bigInteger('product_id');
			$table->integer('qnt');
			$table->decimal('price', 10,2);
			$table->decimal('cost', 10,2);
			$table->string('currency', 20);
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
		Schema::dropIfExists('order_items');
	}
}
