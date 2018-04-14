<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Content;
use App\Content_Translate;
use App\LqOption;
use App\Traits\TIndexImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContentController extends Controller
{
	use TIndexImage;
	
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');
			
			if ($searchtext != '') {
				$list = Content::with('translates')->whereHas('translates', function ($query) use ($searchtext) {
						$query->where('meta_title', 'like', '%' . $searchtext . '%')
							->orWhere('meta_description', 'like', '%' . $searchtext . '%')
							->orWhere('meta_keywords', 'like', '%' . $searchtext . '%');
					})
					->with('uploader')->orWhereHas('uploader', function ($query) use ($searchtext) {
						$query->where('name', 'like', '%' . $searchtext . '%');
					})
					->orWhere('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orWhere('created_at', 'like', '%' . str_replace('.', '-', $searchtext) . '%')
					->orWhere('updated_at', 'like', '%' . str_replace('.', '-', $searchtext) . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = Content::orderby($sort, $direction)->paginate($length);
			}
			
			return view('admin.contents.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
		
		return view('admin.contents.index');
	}
	
	public function edit (Request $request, $id = 0) {
		$image_sizes = explode(',', lqOption('content_image_sizes', '80*80,250*250,500*500'));
		$settings = [
			['title' => trans('admin.Index képek elérési útvonala'), 'value' => lqOption('content_image_path', 'uploads/contents')],
			['title' => trans('admin.Eredeti képek elérési útvonala'), 'value' => lqOption('content_image_original_path', 'uploads/contents/original')],
			['title' => trans('admin.Feltöltött képek méretezése'), 'value' => implode(', ', $image_sizes)],
			['title' => 'upload_max_filesize', 'value' => ini_get('upload_max_filesize')],
			['title' => 'post_max_size', 'value' => ini_get('post_max_size')],
		];
		
		$model = Content::findOrNew($id);
		if (empty($model->uploader_user_id)) $model->uploader_user_id = Auth::user()->id;
		
		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = ['title' => 'Cím', 'indexImage' => trans('admin.Indexkép')];
			$rules = ['name' => 'required', 'indexImage' => 'image|mimes:jpeg,png,jpg,gif,svg'];
			
			foreach (config('app.languages') as $lang) {
				$rules['translate.' . $lang . '.meta_title'] = 'required';
				$niceNames['translate.' . $lang . '.meta_title'] = trans('admin.' . $lang) . '/' . trans('admin.Cím');
			}
			
			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_contents_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('admin.Sikertelen mentés'),
					trans('admin.A tartalom adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// data save
			$model->fill($request->all());
			$model->save();
			
			// Translates save
			foreach ($request->get('translate') as $lang => $t) {
				if (!$translate = $model->translates()->where('language_code', $lang)->first()) {
					$translate = new Content_Translate();
					$translate->content_id = $model->id;
					$translate->language_code = $lang;
				}
				$translate->fill($t);
				if ($translate->slug == '') $translate->slug = Str::slug($translate->meta_title, '-');
				if ($translate->meta_description == '') $translate->meta_description = Str::limit(strip_tags($translate->lead) != '' ? strip_tags($translate->lead) : strip_tags($translate->body), 250, '...');
				$translate->save();
			}
			
			// Index image
			if ($indexImage = $request->file('indexImage')) {
				$new_filename = $this->saveIndexImage($indexImage, $model, lqOption('content_image_original_path', 'uploads/contents/original'), lqOption('content_image_path', 'uploads/contents'), $image_sizes);
				$model->index_image = $new_filename;
				$model->save();
			}
			else if ($request->get('delete_indexImage')) {
				$this->deleteIndexImage($model, lqOption('content_image_original_path', 'uploads/contents/original'), lqOption('content_image_path', 'uploads/contents'), $image_sizes);
				$model->index_image = NULL;
				$model->save();
			}
			
			return redirect(route('admin_contents_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('A tartalom adatai sikeresen rögzítve lettek.'),
			]);
		}
		
		return view('admin.contents.edit', [
			'model' => $model,
			'tab' => $request->get('tab', 'general_data'),
			'categories' => Category::all(),
			'image_sizes' => $image_sizes,
			'indexImages' => $model->images,
			'settings' => $settings,
		]);
	}
	
	public function delete ($id) {
		if ($model = Content::find($id)) {
			$model->translates()->delete();
			$model->delete();
			return redirect(route('admin_contents_list'))->with('form_success_message', [
				trans('admin.Sikeres törlés'),
				trans('admin.A tartalom sikeresen el lett távolítva.')
			]);
		}
	}
	
	public function indexImagesResize () {
		// delete old resized files and directories
		foreach (File::directories(lqOption('content_image_path', 'uploads/contents')) as $path) {
			if (!Str::contains(str_replace('\\', '/', $path), lqOption('content_image_original_path', 'uploads/contents/original'))) {
				File::deleteDirectory($path);
			}
		}
		
		// create new resized files and directories
		foreach (content::whereNotNull('index_image')->get() as $model) {
			$this->resizeIndexImage($model, lqOption('content_image_original_path', 'uploads/contents/original'), lqOption('content_image_path', 'uploads/contents'), explode(',', lqOption('content_image_sizes', '80*80,250*250,500*500')), $model->index_image, lqOption('content_image_aspect_ratio', 0));
		}
		
		return redirect(route('admin_contents_list'))->with('form_success_message', [
			trans('Sikeres átméretezés'),
			trans('A tartalmak indexképei sikeresen át lettek méretezve a következőkre: ' . lqOption('content_image_sizes', '80*80,250*250,500*500')),
		]);
	}
}
