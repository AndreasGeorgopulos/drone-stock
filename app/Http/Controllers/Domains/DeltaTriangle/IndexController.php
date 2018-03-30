<?php

namespace App\Http\Controllers\Domains\DeltaTriangle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index () {
        return view('delta-triangle.main');
    }
}
