<?php

namespace App;

use App\Traits\TIndexImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
	use SoftDeletes, TIndexImage;
	
	protected $table = 'contents';
	protected $fillable = ['name', 'category_id'];
	
	public function uploader () {
		return $this->hasOne('App\User', 'id', 'uploader_user_id');
	}
	
	public function translates () {
		return $this->hasMany('App\Content_Translate');
	}
	
	public function category () {
		return $this->hasOne('App\Category', 'id', 'category_id');
	}
	
	public function getImagesAttribute () {
		if ($this->index_image != NULL) {
			return $this->getIndexImages($this->index_image, lqOption('content_image_original_path', 'uploads/categories/original'), lqOption('content_image_path', 'uploads/contents'), explode(',', lqOption('content_image_sizes', '80*80,250*250,500*500')));
		}
	}
}
