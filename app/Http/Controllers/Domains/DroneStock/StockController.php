<?php

namespace App\Http\Controllers\Domains\DroneStock;

use App\Category;
use App\Category_Translate;
use App\Stock;
use App\Stock_Translate;
use App\Traits\TFrontend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
	use TFrontend;
	
	public function category ($category_slug) {
		$is_admin = Auth::check() ? Auth::user()->roles()->whereIn('key', ['superadmin', 'categories'])->count() : 0;
		if (!($t = Category_Translate::where('slug', $category_slug)->first()) || (!$t->active && !$is_admin)) {
			return redirect('/');
		}
		if (!($category = Category::find($t->category_id)) || (!$category->active && !$is_admin)) {
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
		$is_admin = Auth::check() ? Auth::user()->roles()->whereIn('key', ['superadmin', 'stock'])->count() : 0;
		if (!($t = Category_Translate::where('slug', $category_slug)->first()) || (!$t->active && !$is_admin)) {
			return redirect('/');
		}
		if (!($category = Category::find($t->category_id)) || (!$category->active && !$is_admin)) {
			return redirect('/');
		}
		
		if (!($t = Stock_Translate::where('slug', $stock_slug)->first()) || (!$t->active && !$is_admin)) {
			return redirect('/video/' . $category_slug);
		}
		if (!($stock = Stock::find($t->stock_id)) || (!$stock->active && !$is_admin)) {
			return redirect('/video/' . $category_slug);
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
