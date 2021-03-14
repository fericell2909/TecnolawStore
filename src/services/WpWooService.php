<?php
namespace Tecnolaw\Shop\Services;

use \Automattic\WooCommerce\Client;

class WpWooService
{
	protected $woocommerce = null;

	function __construct() {
		$this->woocommerce = new Client(
			env('WP_URL'),
			env('CONSUMER_KEY'),
			env('CONSUMER_SECRET'),
			[
				'wp_api' => true,
				'version' => 'wc/v3',
				'query_string_auth' => true
			]
		);
	}
	public function categories($data=['page'=>1]){
		return $this->woocommerce->get('products/categories',$data);
	}

	public function products($data=['page'=>1]){
		return $this->woocommerce->get('products',$data);
	}
}