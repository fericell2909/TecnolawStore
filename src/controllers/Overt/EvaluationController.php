<?php
namespace Tecnolaw\Shop\Controllers\Overt;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Tecnolaw\Shop\Models\ProductEvaluation;
use Tecnolaw\Shop\Models\Product;

class EvaluationController extends BaseController
{
	protected $evaluation=null;
	protected $rules=null;
	protected $rulesAuth=null;

	function __construct()
	{
		$this->evaluation = new ProductEvaluation;
		$this->rules = [
			"product_id" => "required|exists:".(new Product)->getTable().",id",
			"score" => "required|integer|between:1,5'",
			"commentary" => "required|min:5|max:250",
		];
		$this->rulesAuth = [
			"name" => "required|min:10|max:50",
			"email" => "required|email|min:3|max:70",
		];
	}
	public function store(Request $request)
	{
		$id=\Auth::id();
		if ($id) {
			$this->validate($request, $this->rules);
		}else{
			$rules=array_merge($this->rules,$this->rulesAuth);
			$this->validate($request, $rules);
			$id=null;
		}
		$evaluation=ProductEvaluation::create([
			'product_id'=>$request->product_id,
	    	'created_by'=>$id,
			'score'=>$request->score,
			'commentary'=>$request->commentary,
			'name'=>$request->name ?? null,
			'email'=>$request->email ?? null,
		]);

		$data = [
			'status'=>'success',
			'data'=>[
				'message'=>'evaluación exitosa'
			]
		];
		return response($data,200);
	}
}