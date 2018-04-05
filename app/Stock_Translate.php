<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock_Translate extends Model
{
	use SoftDeletes;
	
	protected $table = 'stock_translates';
	protected $fillable = ['slug', 'meta_title', 'meta_description', 'meta_keywords', 'lead', 'body', 'active'];
}
