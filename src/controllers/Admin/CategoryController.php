<?php
namespace Tecnolaw\Shop\Controllers\Admin;

use Tecnolaw\Shop\Controllers\AppController as BaseController;
use \Illuminate\Http\Request;
use Tecnolaw\Shop\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends BaseController
{
	protected $category=null;
	protected $rules=null;
	protected $categoryFields = [
		'id_wp_woo',
		'created_by',
		'parent_id',
		'order',
		'icon',
		'name',
		'slug'
	];

	function __construct()
	{
		$this->category = new Category;
		$this->rules = [
			'name' => 'required|min:5|max:50'
		];
	}

	/**
	 * @method POST
	 * @link /shop/categories
	 */
	public function create(Request $request)
	{
		$this->validate($request, $this->rules);
		$fields = $request->only($this->categoryFields);
		$fields['slug'] = Str::slug($fields['name']);

		$category = $this->category->create($fields);

		return response([
			'status'=>'success',
			'data'=> $category ,
		], 200);
	}

	/**
	 * @method PUT
	 * @link /shot/categories/{id}
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, $this->rules);
		$fields = $request->only($this->categoryFields);
		$categoryFields['slug'] = Str::slug($fields['name']);

		try {
			$category = $this->category->find($id);
			if ($category == NULL)	
				throw new \Exception("Not found", 404);	
			
			if (isset($fields['parent_id'])){
				$parent = $this->category->find($fields['parent_id']);	
				if ($parent == NULL)
					throw new \Exception("Parent Category not found", 500);

				if ($parent->id === $category->id)
					throw new \Exception("Category and Parent Category are the same", 500);					
			}

			$category->update($fields);	

			return response([
				'status'=>'success',
				'data'=> $category ,
			],200);
		} catch (\Exception $e) {
			return $this->serverError($e);
		}
	}


	/**
	 * @method GET
	 * @link /shot/categories/{id}
	 */
	public function show($id)
	{
		try {
			$category = $this->category->with(['allChildren'])->find($id);
			if ($category == NULL)	
				throw new \Exception("Not found", 404);	
			
			return response([
				'status'=>'success',
				'data'=> $category ,
			],200);
		} catch (\Exception $e) {
			return $this->serverError($e);
		}
	}


	public function delete(Request $request, $id)
	{
		return response([
			'status'=>'success',
			'data'=>[],
		],200);
	}


	public function list(Request $request)
	{
		$list = $this->category->whereNull('parent_id')
			->with(['allChildren'])
			->get();

		$data['status'] = 'success';
		$data['data'] = $list;
		return response($data,200);
	}
}