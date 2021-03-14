<?php

namespace Tecnolaw\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
	use SoftDeletes;

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'tecnolaw_categories';

    protected $fillable = [
        'id_wp_woo',
        'created_by',
        'parent_id',
        'order',
        'icon',
        'name',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }

    public function productsByCategory() {
        return $this->hasMany(CategoriesProducts::class,'category_id','id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

}