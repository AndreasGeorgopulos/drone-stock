<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock_Size extends Model
{
	use SoftDeletes;
	
	protected $table = 'stock_sizes';
	protected $fillable = ['name', 'size', 'fps', 'type', 'file_name', 'file_size', 'price'];
}
