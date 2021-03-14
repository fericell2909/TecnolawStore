<?php

namespace Tecnolaw\Shop\Controllers\Woo;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use Tecnolaw\Shop\Services\WpWooService;

class WooController extends BaseController
{
	public function categories(Request $request)
	{
		$wp_woo = new WpWooService;
		$parametros = ['page'=>1,'per_page'=>50];
		$resul = [];
		$dataWp = $wp_woo->categories();
		return response($dataWp,200);
	}
	public function products(Request $request)
	{
		$wp_woo = new WpWooService;
		$parametros = ['page'=>1,'per_page'=>90];
		$resul = [];
		$dataWp = $wp_woo->products($parametros);
		return response($dataWp,200);
	}
	
}