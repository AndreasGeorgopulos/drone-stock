<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Content_Translate extends Model
{
	use SoftDeletes;
	
	protected $table = 'content_translates';
	protected $fillable = ['slug', 'meta_title', 'meta_description', 'meta_keywords', 'lead', 'body', 'active'];
}
