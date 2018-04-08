<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Category_Translate;
use App\LqOption;
use App\Traits\TIndexImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
	use TIndexImage;
	
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');
			
			if ($searchtext != '') {
				$list = Category::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('title', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Category::orderby($sort, $direction)->paginate($length);
			}
			
			return view('admin.categories.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
		
		return view('admin.categories.index');
	}
	
	public function edit (Request $request, $id = 0) {
		$image_sizes = explode(',', lqOption('category_image_sizes', '80*80,250*250,500*500'));
		$settings = [
			['title' => trans('admin.Index képek elérési útvonala'), 'value' => lqOption('category_image_path', 'uploads/categories')],
			['title' => trans('admin.Eredeti képek elérési útvonala'), 'value' => lqOption('category_image_original_path', 'uploads/categories/original')],
			['title' => trans('admin.Feltöltött képek méretezése'), 'value' => implode(', ', $image_sizes)],
			['title' => 'upload_max_filesize', 'value' => ini_get('upload_max_filesize')],
			['title' => 'post_max_size', 'value' => ini_get('post_max_size')],
		];
		
		$model = Category::findOrNew($id);
		
		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = ['name' => trans('admin.Név'), 'indexImage' => trans('admin.Indexkép')];
			$rules = ['name' => 'required', 'indexImage' => 'image|mimes:jpeg,png,jpg,gif,svg'];
			
			foreach (config('app.languages') as $lang) {
				$rules['translate.' . $lang . '.meta_title'] = 'required';
				$niceNames['translate.' . $lang . '.meta_title'] = trans('admin.' . $lang) . '/' . trans('admin.Cím');
			}
			
			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_categories_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('admin.Sikertelen mentés'),
					trans('admin.A kategória adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// data save
			$model->fill($request->all());
			$model->save();
			
			// Translates save
			foreach ($request->get('translate') as $lang => $t) {
				if (!$translate = $model->translates()->where('language_code', $lang)->first()) {
					$translate = new Category_Translate();
					$translate->category_id = $model->id;
					$translate->language_code = $lang;
				}
				$translate->fill($t);
				if ($translate->slug == '') $translate->slug = Str::slug($translate->meta_title, '-');
				if ($translate->meta_description == '') $translate->meta_description = Str::limit(strip_tags($translate->meta_lead) != '' ? strip_tags($translate->meta_lead) : strip_tags($translate->meta_body), 250, '...');
				$translate->save();
			}
			
			// Index image
			if ($indexImage = $request->file('indexImage')) {
				$new_filename = $this->saveIndexImage($indexImage, $model, lqOption('category_image_original_path', 'uploads/categories/original'), lqOption('category_image_path', 'uploads/categories'), $image_sizes);
				$model->index_image = $new_filename;
				$model->save();
			}
			else if ($request->get('delete_indexImage')) {
				$this->deleteIndexImage($model, lqOption('category_image_original_path', 'uploads/categories/original'), lqOption('category_image_path', 'uploads/categories'), $image_sizes);
				$model->index_image = NULL;
				$model->save();
			}
			
			return redirect(route('admin_categories_edit', ['id' => $model->id]))->withInput()->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A kategória adatai sikeresen rögzítve lettek.'),
			]);
		}
		
		return view('admin.categories.edit', [
			'model' => $model,
			'tab' => $request->get('tab', 'general_data'),
			'image_sizes' => $image_sizes,
			'indexImages' => $model->images,
			'settings' => $settings,
		]);
	}
	
	public function delete ($id) {
		if ($model = Category::find($id)) {
			$this->deleteIndexImage($model, lqOption('category_image_original_path', 'uploads/categories/original'), lqOption('category_image_path', 'uploads/categories'), explode(',', LqOption::where('lq_key', 'like', 'category_image_sizes')->first()->lq_value));
			$model->translates()->delete();
			$model->delete();
			return redirect(route('admin_categories_list'))->with('form_success_message', [
				trans('admin.Sikeres törlés'),
				trans('admin.A kategória sikeresen el lett távolítva.')
			]);
		}
	}
	
	public function indexImagesResize () {
		// delete old resized files and directories
		foreach (File::directories(lqOption('category_image_path', 'uploads/categories')) as $path) {
			if (!Str::contains(str_replace('\\', '/', $path), lqOption('category_image_original_path', 'uploads/categories/original'))) {
				File::deleteDirectory($path);
			}
		}
		
		// create new resized files and directories
		foreach (Category::whereNotNull('index_image')->get() as $model) {
			$this->resizeIndexImage($model, lqOption('category_image_original_path', 'uploads/categories/original'), lqOption('category_image_path', 'uploads/categories'), explode(',', lqOption('category_image_sizes', '80*80,250*250,500*500')), $model->index_image);
		}
		
		return redirect(route('admin_categories_list'));
	}
}
