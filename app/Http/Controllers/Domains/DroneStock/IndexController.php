<?php

namespace App\Http\Controllers\Domains\DroneStock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index () {
        return view('drone-stock.main');
    }
}
