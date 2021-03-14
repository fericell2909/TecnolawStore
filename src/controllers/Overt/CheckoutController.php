<?php
namespace Tecnolaw\Shop\Controllers\Overt;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Tecnolaw\Shop\Models\ShoppingCart;

class CheckoutController extends BaseController
{
	protected $car=null;
	protected $rules=null;

	function __construct()
	{
		$this->car = new ShoppingCart;
		$this->rules = [
		];
	}
	public function get(Request $request)
	{
		$list = $this->car->whereNull('parent_id')->with(['allChildren'])->get();
		$data = [
			'status'=>'success',
			'data'=>$list->toArray()
		];
		return response($data,200);
	}
}