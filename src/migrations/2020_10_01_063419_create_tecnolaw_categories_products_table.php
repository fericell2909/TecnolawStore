<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecnolawCategoriesProductsTable extends Migration
{
	public $tableName = 'tecnolaw_categories_products';

	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id');
			$table->unsignedBigInteger('created_by')->nullable();
			$table->unsignedBigInteger('category_id');
			$table->unsignedBigInteger('product_id');
			
			$table->index(['created_by'], 'fk_categories_products_users_idx');
			$table->foreign('created_by', 'fk_categories_products_users_idx')
				->references('id')->on('tecnolaw_users')
				->onDelete('no action')
				->onUpdate('no action');

			$table->index(['category_id'], 'fk_category_id_shopping_carts_idx');
			$table->foreign('category_id', 'fk_category_id_shopping_carts_idx')
				->references('id')->on('tecnolaw_categories')
				->onDelete('no action')
				->onUpdate('no action');

			$table->index(['product_id'], 'fk_product_id_shopping_carts_idx');
			$table->foreign('product_id', 'fk_product_id_shopping_carts_idx')
				->references('id')->on('tecnolaw_products')
				->onDelete('no action')
				->onUpdate('no action');

			$table->dateTime('created_at')->nullable();
			$table->dateTime('updated_at')->nullable();
			$table->dateTime('deleted_at')->nullable();
		});
	}
	public function down()
	{
		Schema::dropIfExists($this->tableName);
	}
}