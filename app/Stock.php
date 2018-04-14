<?php

namespace App;

use App\Traits\TIndexImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
	use SoftDeletes, TIndexImage;
	
	protected $table = 'stocks';
    protected $fillable = ['name', 'clip_length', 'aspect_ratio', 'active', 'category_id'];
	
	public function uploader () {
		return $this->hasOne('App\User', 'id', 'uploader_user_id');
	}
	
	public function sizes () {
		return $this->hasMany('App\Stock_Size');
	}
    
    public function translates () {
		return $this->hasMany('App\Stock_Translate');
	}
	
	public function category () {
		return $this->hasOne('App\Category', 'id', 'category_id');
	}
	
	public function getImagesAttribute () {
		if ($this->index_image != NULL) {
			return $this->getIndexImages($this->index_image, lqOption('stock_image_original_path', 'uploads/categories/original'), lqOption('stock_image_path', 'uploads/stocks'), explode(',', lqOption('stock_image_sizes', '80*80,250*250,500*500')));
		}
	}
}
