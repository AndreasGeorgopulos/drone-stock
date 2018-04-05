<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content extends Model
{
	use SoftDeletes;
	
	protected $table = 'contents';
	protected $fillable = ['title'];
	
	public function translates () {
		return $this->hasMany('App\Content_Translate');
	}
}
