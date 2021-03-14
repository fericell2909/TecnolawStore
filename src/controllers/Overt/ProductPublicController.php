<?php

namespace Tecnolaw\Shop\Controllers\Overt;

//use Laravel\Lumen\Routing\Controller as BaseController;
use Tecnolaw\Shop\Controllers\AppController as BaseController;
use Illuminate\Http\Request;

use Tecnolaw\Shop\Models\Product;
use Tecnolaw\Shop\Models\Category;
use Tecnolaw\Shop\Models\CategoriesProducts;
use Tecnolaw\Shop\Resources\ProductsByCategory;
use Tecnolaw\Shop\Resources\ProductWithRelated;
use Tecnolaw\Shop\Resources\ProductCollection;

class ProductPublicController extends BaseController
{
	protected $product=null;
	protected $rules=null;

	function __construct()
	{
		$this->product = new Product;
		$this->rules = [
		];
	}
	
	/**
	 * Parametros en request
	 * 	- rows => Cantidad de registros
	 *  - category_slug => Categoria (Padre o hijo)
	 *  - search => filtra por el nombre del producto
	 */
	public function list(Request $request)
	{
		$rows = $request->input('rows', 12 );
		$cat_slug = $request->input('category_slug', NULL);
		$search = urldecode($request->input('search', NULL));
		
		try {
			// Se filtra por slug de categoria
			if ($cat_slug != NULL){
				$category = Category::where('slug', $cat_slug)->first();
				if ($category == NULL)
					throw new \Exception("Not found", 404);	

				return ProductsByCategory::collection(
					$category->productsByCategory()->paginate($rows)
				)->additional(['category_slug' => $cat_slug]);
			} 
			
			$list = $this->product->with(['gallery','category'])->available();
			if ($search != NULL) $list->where('name', 'like', "%$search%");
			
			return new ProductCollection($list->paginate($rows));

		} catch (\Exception $e) {
			return $this->serverError($e);
		}

	}

	public function show($param,$value)
	{
		$p = $this->product
			->with(['gallery','category','evaluations'])
			->available()
			->where([
				[$param,'=',$value]
			])
			->first();

		return new ProductWithRelated($p);
		
		$data = array_merge(
			['status' => $p ? 'success' : 'not_found'],
			['data' => $p ? $p->toArray() : null]
		);
		return response($data, 200);
	}
}