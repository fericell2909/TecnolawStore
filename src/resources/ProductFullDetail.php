<?php

namespace Tecnolaw\Shop\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Tecnolaw\Shop\Models\CategoriesProducts;

class ProductFullDetail extends JsonResource
{
    public function toArray($request)
    {
    	return parent::toArray($request);
    }
}

?>