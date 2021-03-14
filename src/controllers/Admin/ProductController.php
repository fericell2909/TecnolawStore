<?php
namespace Tecnolaw\Shop\Controllers\Admin;

use Tecnolaw\Shop\Controllers\AppController as BaseController;
use \Illuminate\Http\Request;
use Tecnolaw\Shop\Models\Product;
use Illuminate\Support\Str;

class ProductController extends BaseController
{
	protected $product=null;
	protected $rules=null;
	protected $productFields = [
		'sku',
		'name',
		'description',
		'short_description',
		'total_sales',
		'unit',
		'price',
		'discount',
		'quantity',
		'active'
	];

	function __construct()
	{
		$this->product = new Product;
		$this->rules = [
			'sku' => 'required|unique:'.(new Product)->getTable().',sku',
			'name' => 'required|min:5|max:50',
			'description' => 'required',
			'short_description' => 'required|min:30|max:300',
			//'total_sales' =>
			'unit' => 'required',
			'price' => 'required',
			'discount' => 'required',
			'quantity' => 'required',
			'active' => 'required|in:0,1'
		];
	}

	/**
	 * @method POST
	 * @link /shop/product
	 */
	public function create(Request $request)
	{
		$this->validate($request, $this->rules);
		$fields = $request->only($this->productFields);
		$fields['slug'] = Str::slug($fields['name']);

		$product = $this->product->create($fields);

		return response([
			'status'=>'success',
			'data'=> $product ,
		], 200);
	}

	/**
	 * @method PUT
	 * @link /shot/product/{id}
	 */
	public function update(Request $request, $id)
	{
		$rules = collect($this->rules);
		$rules->forget('sku');

		$this->validate($request, $rules->all());
		$fields = $request->only($this->productFields);
		$fields['slug'] = Str::slug($fields['name']);

		try {
			$product = $this->product->find($id);
			if ($product == NULL)
				throw new \Exception("Not found", 404);

			$product->update($fields);

			return response([
				'status'=>'success',
				'data'=> $product ,
			],200);
		} catch (\Exception $e) {
			return $this->serverError($e);
		}
	}


	/**
	 * @method GET
	 * @link /shot/product/{id}
	 */
	public function show($id)
	{
		try {
			$product = $this->product->with(['gallery','category'])->find($id);

			if ($product == NULL)
				throw new \Exception("Not found", 404);

			return response([
				'status'=>'success',
				'data'=> $product ,
			],200);
		} catch (\Exception $e) {
			return $this->serverError($e);
		}
	}


	public function delete(Request $request)
	{
		return response([
			'status'=>'success',
			'data'=>[],
		],200);
	}


	public function list(Request $request)
	{
		$list = $this->product->with(['gallery','category'])->paginate(12);
		$data = array_merge(
			['status'=>'success',],
			$list->toArray()
		);
		return response($data,200);
	}
}
