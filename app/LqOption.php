<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LqOption extends Model
{
    protected $table = 'lq_options';
    protected $fillable = ['lq_key', 'lq_value', 'notice'];
}
