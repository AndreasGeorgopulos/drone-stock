<?php

namespace App\Http\Controllers\Domains\DroneStock;

use App\Category;
use App\Category_Translate;
use App\Stock;
use App\Stock_Translate;
use App\Traits\TFrontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StockController extends Controller
{
	use TFrontend;
	
	public function category ($category_slug) {
		if (!$t = Category_Translate::where('slug', $category_slug)->where('active', 1)->first()) {
			return redirect('/');
		}
		if (!($category = Category::find($t->category_id)) || !$category->active) {
			return redirect('/');
		}
		$this->setLanguage($t->language_code);
		
		$meta_data = [
			'title' => $t->meta_title,
			'description' => $t->meta_description,
			'keywords' => $t->meta_keywords,
			'social_image' => !empty($category->images['500_500']['url']) ? $category->images['500_500']['url'] : ''
		];
		
		return $this->view('drone-stock.category', [
			'category' => $category,
			't' => $t,
			'meta_data' => $meta_data,
			'category_slug' => $category_slug,
		]);
	}
	
	public function stock ($category_slug, $stock_slug) {
		if (!$t = Category_Translate::where('slug', $category_slug)->where('active', 1)->first()) {
			return redirect('/');
		}
		if (!($category = Category::find($t->category_id)) || !$category->active) {
			return redirect('/');
		}
		
		if (!$t = Stock_Translate::where('slug', $stock_slug)->where('active', 1)->first()) {
			return redirect('/v-stock/' . $category_slug);
		}
		if (!($stock = Stock::find($t->stock_id)) || !$stock->active) {
			return redirect('/v-stock/' . $category_slug);
		}
		$this->setLanguage($t->language_code);
		
		$meta_data = [
			'title' => $t->meta_title,
			'description' => $t->meta_description,
			'keywords' => $t->meta_keywords,
			'social_image' => !empty($category->images['500_500']['url']) ? $category->images['500_500']['url'] : ''
		];
		
		return $this->view('drone-stock.stock', [
			'category' => $category,
			'stock' => $stock,
			't' => $t,
			'meta_data' => $meta_data,
			'category_slug' => $category_slug,
		]);
	}
}
