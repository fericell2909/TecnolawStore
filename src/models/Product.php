<?php

namespace Tecnolaw\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
	use SoftDeletes;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tecnolaw_products';

	protected $fillable = [
		'created_by',
		'sku',
		'name',
		'slug',
		'description',
		'short_description',
		'total_sales',
		'unit',
		'price',
		'discount',
		'quantity',
		'active',
	];

	protected $hidden = [
		'created_at',
		'updated_at'
	];

	public function getPriceAttribute($value)
    {
    	// aqui se peude establecer el tipo de valor
        return (int) $value;
    }

	public function gallery()
	{
		$className='\Tecnolaw\File\Models\ProductGallery';
		if (class_exists($className)) {
			return $this->hasMany($className)->orderBy('order', 'ASC')->with(['file']);
		}else{
			return $this->hasMany(Product::class,'id')->whereNull('id');
		}
	}

	public function category()
	{
		return $this->belongsToMany(Category::class,(new CategoriesProducts)->getTable())
		->withPivot(
			'category_id',
			'product_id',
		);
		//return $this->hasMany(CategoriesProducts::class);
	}


	public function evaluations()
	{

        $className='\Tecnolaw\Shop\Models\ProductEvaluation';
		if (class_exists($className)) {
			return $this->hasMany($className)->with(['file']);
		}else{
			return $this->hasMany($className);
        }

	}

	public function scopeAvailable($query)
	{
		return $query->where([
			['active','=',1],
			['quantity','>',0],
		]);
	}
}
