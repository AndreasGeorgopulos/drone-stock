<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\LqOption;
use App\Stock;
use App\Stock_Size;
use App\Stock_Translate;
use App\Traits\TIndexImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StockController extends Controller
{
	use TIndexImage;
	
    public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');
		
			if ($searchtext != '') {
				$list = Stock::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Stock::orderby($sort, $direction)->paginate($length);
			}
		
			return view('admin.stock.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
	
		return view('admin.stock.index');
	}
	
	public function edit (Request $request, $id = 0) {
		$image_sizes = LqOption::where('lq_key', 'like', 'stock_image_size_%')->get();
		$settings = [
			['title' => trans('admin.Index képek elérési útvonala'), 'value' => lqOption('stock_image_path', 'uploads/stocks')],
			['title' => trans('admin.Eredeti képek elérési útvonala'), 'value' => lqOption('stock_image_original_path', 'uploads/stocks/original')],
			['title' => trans('admin.Feltöltött képek méretezése'), 'value' => collect($image_sizes)->implode('lq_value',	', ')],
			['title' => 'upload_max_filesize', 'value' => ini_get('upload_max_filesize')],
			['title' => 'post_max_size', 'value' => ini_get('post_max_size')],
		];
		
		$model = Stock::findOrNew($id);
		
		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = [
				'name' => trans('admin.Általános adatok') . '/' . trans('admin.Név'),
				'clip_length' => trans('admin.Általános adatok') . '/' . trans('admin.Klip hossza'),
				'aspect_ratio' => trans('admin.Általános adatok') . '/' . trans('admin.Képarány'),
				'indexImage' => trans('admin.Indexkép'),
			];
			$rules = [
				'name' => 'required',
				'clip_length' => 'required',
				'aspect_ratio' => 'required',
				'indexImage' => 'image|mimes:jpeg,png,jpg,gif,svg',
			];
			
			foreach (config('app.languages') as $lang) {
				$rules['translate.' . $lang . '.meta_title'] = 'required';
				$niceNames['translate.' . $lang . '.meta_title'] = trans('admin.' . $lang) . '/' . trans('admin.Cím');
			}
			
			$stock_size = $request->get('stock_size');
			if ($stock_size['file_name'] != '' && $stock_size['file_size'] != '') {
				$rules['stock_size.name'] = 'required';
				$rules['stock_size.type'] = 'required';
				$rules['stock_size.size'] = 'required';
				$rules['stock_size.fps'] = 'required';
				$niceNames['stock_size.name'] = trans('admin.Video file-ok') . '/' . trans('admin.Név');
				$niceNames['stock_size.type'] = trans('admin.Video file-ok') . '/' . trans('admin.Típus');
				$niceNames['stock_size.size'] = trans('admin.Video file-ok') . '/' . trans('admin.Méret');
				$niceNames['stock_size.fps'] = trans('admin.Video file-ok') . '/' . trans('admin.Fps');
			}
			
			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_stock_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('admin.Sikertelen mentés'),
					trans('admin.A v-stock adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// data save
			$model->fill($request->all());
			$model->save();
			
			// Translates save
			foreach ($request->get('translate') as $lang => $t) {
				if (!$translate = $model->translates()->where('language_code', $lang)->first()) {
					$translate = new Stock_Translate();
					$translate->stock_id = $model->id;
					$translate->language_code = $lang;
				}
				$translate->fill($t);
				if ($translate->slug == '') $translate->slug = Str::slug($translate->meta_title, '-');
				if ($translate->meta_description == '') $translate->meta_description = Str::limit(strip_tags($translate->meta_lead) != '' ? strip_tags($translate->meta_lead) : strip_tags($translate->meta_body), 250, '...');
				$translate->save();
			}
			
			// video files
			if ($stock_size['file_name'] != '' && $stock_size['file_size'] != '') {
				$size = new Stock_Size();
				$size->fill($stock_size);
				$size->stock_id = $model->id;
				$size->save();
			}
			
			// delete video sizes
			if ($sizes = $request->get('delete_stock_sizes')) {
				foreach ($sizes as $id) {
					$size = Stock_Size::find($id);
					$size->delete();
				}
			}
			
			// delete files
			if ($files = $request->get('delete_files')) {
				foreach ($files as $file) {
					$path = config('vstock.path') . $file;
					if (file_exists($path)) unlink($path);
				}
			}
			
			// Index image
			if ($indexImage = $request->file('indexImage')) {
				$new_filename = $this->saveIndexImage($indexImage, $model, lqOption('stock_image_original_path', 'uploads/stocks/original'), lqOption('stock_image_path', 'uploads/stocks'), $image_sizes);
				$model->index_image = $new_filename;
				$model->save();
			}
			else if ($request->get('delete_indexImage')) {
				$this->deleteIndexImage($model, lqOption('stock_image_original_path', 'uploads/stocks/original'), lqOption('stock_image_path', 'uploads/stocks'), $image_sizes);
				$model->index_image = NULL;
				$model->save();
			}
			
			return redirect(route('admin_stock_edit', ['id' => $model->id]))->withInput()->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A v-stock adatai sikeresen rögzítve lettek.'),
			]);
		}
		
		return view('admin.stock.edit', [
			'model' => $model,
			'video_files' => $this->getFiles(),
			'tab' => $request->get('tab', 'general_data'),
			'categories' => Category::all(),
			'image_sizes' => $image_sizes,
			'indexImages' => $model->images,
			'settings' => $settings,
		]);
	}
	
	private function getFiles () {
    	$files = [];
		foreach (File::allFiles(config('vstock.path')) as $file) {
			if (!Stock_Size::where('file_name', '=', str_replace('\\', '/', $file->getRelativePathname()))->first()) {
				$files[] = $file;
			}
		}
		return $files;
	}
	
	public function delete ($id) {
		if ($model = Stock::find($id)) {
			$model->translates()->delete();
			$model->sizes()->delete();
			$model->delete();
			return redirect(route('admin_stock_list'))->with('form_success_message', [
				trans('admin.Sikeres törlés'),
				trans('admin.A v-stock sikeresen el lett távolítva.')
			]);
		}
	}
	
	public function indexImagesResize () {
		// delete old resized files and directories
		foreach (File::directories(lqOption('stock_image_path', 'uploads/stocks')) as $path) {
			if (!Str::contains(str_replace('\\', '/', $path), lqOption('stock_image_original_path', 'uploads/stocks/original'))) {
				File::deleteDirectory($path);
			}
		}
		
		// create new resized files and directories
		foreach (stock::whereNotNull('index_image')->get() as $model) {
			$this->resizeIndexImage($model, lqOption('stock_image_original_path', 'uploads/stocks/original'), lqOption('stock_image_path', 'uploads/stocks'), LqOption::where('lq_key', 'like', 'stock_image_size_%')->get(), $model->index_image);
		}
		
		return redirect(route('admin_stocks_list'));
	}
}