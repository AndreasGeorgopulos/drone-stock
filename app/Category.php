<?php

namespace App;

use App\Traits\TIndexImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, TIndexImage;
	
	protected $table = 'categories';
	protected $fillable = ['name', 'active'];
	
	public function uploader () {
		return $this->hasOne('App\User', 'id', 'uploader_user_id');
	}
 
	public function translates () {
		return $this->hasMany('App\Category_Translate');
	}
	
	public function contents () {
		return $this->hasMany('App\Contents');
	}
	
	public function stocks () {
		return $this->hasMany('App\Stock');
	}
	
	public function getImagesAttribute () {
		if ($this->index_image != NULL) {
			return $this->getIndexImages($this->index_image, lqOption('category_image_original_path', 'uploads/categories/original'), lqOption('category_image_path', 'uploads/categories'), explode(',', lqOption('category_image_sizes', '80*80,250*250,500*500')));
		}
	}
}
