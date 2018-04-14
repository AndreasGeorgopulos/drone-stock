<?php

namespace App\Http\Controllers\Domains\DroneStock;

use App\Category;
use App\Category_Translate;
use App\Stock;
use App\Stock_Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\TFrontend;
use Illuminate\Support\Facades\App;
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
    
    public function search (Request $request, $searchtext) {
    	// vstock
		$vstock_list = Stock::where(function($query) use ($searchtext) {
			foreach (explode(' ', $searchtext) as $word) {
				$query->with('translates')->whereHas('translates', function ($q) use ($word) {
					$q->where('meta_title', 'like', '%' . $word . '%')
						->orWhere('lead', 'like', '%' . $word . '%')
						->orWhere('body', 'like', '%' . $word . '%');
				});
			}
		})->get();
	
		return $this->view('drone-stock.search', [
			'searchtext' => $searchtext,
			'total' => count($vstock_list),
			'results' => [
				'vstock' => $vstock_list
			],
		]);
	}
    
    public function changeLanguage (Request $request, $lang) {
    	if (in_array($lang, config('app.languages'))) {
			$this->setLanguage($lang);
		}
		return redirect('/');
	}
}
