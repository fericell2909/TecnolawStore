<?php

namespace Tecnolaw\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductEvaluation extends Model
{
	use SoftDeletes;

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'tecnolaw_products_evaluations';

    protected $fillable = [
    	'product_id',
    	'created_by',
		'score',
		'commentary',
		'name',
        'email',
        'created_at',
        'title_commentary',
        'file_id'
    ];

    protected $hidden = [
        'updated_at',
        'email'
    ];

    public function getNameAttribute($value)
    {

        $name = $this->user->fullName ?? $value;
        if($this->user){
            unset($this->user);
        }
        return $name;
    }
    public function user()
    {
        return $this->belongsTo(\Tecnolaw\Authorization\Models\User::class,'created_by');
    }

    public function file() {
        return $this->belongsTo(\Tecnolaw\File\Models\File::class,'file_id');
    }
}
