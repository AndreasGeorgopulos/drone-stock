<?php

namespace App\Http\Controllers\Domains\DroneStock;

use App\Category;
use App\Category_Translate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TFrontend;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
	use TFrontend;
	
    public function index () {
		$meta_data = [
			'title' => 'Teszt 1',
			'description' => 'Teszt 2 desc',
			'keywords' => 'test, teszt, key, word, keyword',
			'social_image' => asset('uploads/categories/250_250/1_front.jpg'),
		];
		
		return $this->view('drone-stock.main', [
    		'meta_data' => $meta_data,
			'categories' => Category::where('active', 1)->get(),
		]);
    }
    
    public function changeLanguage (Request $request, $lang) {
		$this->setLanguage($lang);
	}
}
