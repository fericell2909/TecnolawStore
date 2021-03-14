<?php

$router=$this->app->router;
$router->group([
		'namespace' => 'Tecnolaw\Shop\Controllers\Admin',
		'prefix' => 'shop',
		'middleware' => ['TecnolawAuthAdmin']
	],function() use ($router) {
		// Products
		$router->group(['prefix' => 'admin'], function () use ($router) {
			$router->post('product', 'ProductController@create');
			$router->get('product/list', 'ProductController@list');
			$router->get('product/{id}', 'ProductController@show');
			$router->put('product/{id}', 'ProductController@update');
			$router->delete('product/{id}', 'ProductController@delete');

			$router->post('categories', 'CategoryController@create');
			$router->get('categories', 'CategoryController@list');
			$router->get('categories/{id}', 'CategoryController@show');
			$router->put('categories/{id}', 'CategoryController@update');
			$router->delete('categories/{id}', 'CategoryController@delete');			
		});

	}
);
$router->get('wp/woo/categories', 'Tecnolaw\Shop\Controllers\Woo\WooController@categories');
$router->get('wp/woo/products', 'Tecnolaw\Shop\Controllers\Woo\WooController@products');



$router->group([
		'namespace' => 'Tecnolaw\Shop\Controllers\Overt',
		'prefix' => 'shop',
	],function() use ($router) {
		// Category
		$router->get('categories', 'CategoryController@list');
		$router->get('categories/{slug}', 'CategoryController@show');

		// Evaluation
		$router->post('product/evaluation', 'EvaluationController@store');

		// Product
		$router->get('product/list', 'ProductPublicController@list');
		$router->get('product/{param}/{value}', 'ProductPublicController@show');
		
		$router->group([
				'middleware' => ['TecnolawAuth']
			],function() use ($router) {
				// Cart
				$router->post('shopping/cart', 'ShoppingCartController@cart');

			}
		);
	}
);

