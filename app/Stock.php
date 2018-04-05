<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
	use SoftDeletes;
	
	protected $table = 'stocks';
    protected $fillable = ['name', 'clip_length', 'aspect_ratio', 'active'];
	
	
	public function sizes () {
		return $this->hasMany('App\Stock_Size');
	}
    
    public function translates () {
		return $this->hasMany('App\Stock_Translate');
	}
}
