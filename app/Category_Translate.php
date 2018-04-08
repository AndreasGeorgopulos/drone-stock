<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_Translate extends Model
{
	use SoftDeletes;
	
	protected $table = 'category_translates';
	protected $fillable = ['slug', 'meta_title', 'meta_description', 'meta_keywords', 'active'];
}
