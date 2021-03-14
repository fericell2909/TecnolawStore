<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTecnolawProductsEvaluationsTable extends Migration
{
	public $tableName = 'tecnolaw_products_evaluations';

	public function up()
	{
		Schema::create($this->tableName, function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->unsignedBigInteger('product_id')->nullable();
			$table->unsignedBigInteger('created_by')->nullable();
			$table->integer('score')->nullable();
			$table->string('commentary',250)->nullable();
			$table->string('name',50)->nullable();
			$table->string('email',70)->nullable();

			$table->index(['product_id'], 'fk_product_id_products_evaluations_idx');
			$table->foreign('product_id', 'fk_product_id_products_evaluations_idx')
				->references('id')->on('tecnolaw_products')
				->onDelete('no action')
				->onUpdate('no action');

			$table->foreign('created_by', 'fk_created_by_users_evaluations_idx2')
				->references('id')->on('tecnolaw_users')
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