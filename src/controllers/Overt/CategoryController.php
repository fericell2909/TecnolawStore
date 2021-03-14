<?php
namespace Tecnolaw\Shop\Controllers\Overt;

//use Laravel\Lumen\Routing\Controller as BaseController;
use Tecnolaw\Shop\Controllers\AppController as BaseController;
use Illuminate\Http\Request;
use Tecnolaw\Shop\Models\Category;

class CategoryController extends BaseController
{
	protected $category=null;
	protected $rules=null;

	function __construct()
	{
		$this->category = new Category;
		$this->rules = [
		];
	}
	public function list(Request $request)
	{
		$list = $this->category->whereNull('parent_id')
			->with(['allChildren'])
			->get();
		$data = [
			'status'=>'success',
			'data'=>$list->toArray()
		];
		return response($data,200);
	}

	public function show($slug){
		try {
			$data = $this->category->with(['allChildren'])
				->where('slug', $slug)->first();	
			if ($data == NULL) throw new \Exception("Not found", 404);

			return ['data' => $data ];
		} catch (\Exception $e) {
			return $this->serverError($e);
		}

	}
}