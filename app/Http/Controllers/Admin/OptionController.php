<?php

namespace App\Http\Controllers\Admin;

use App\LqOption;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OptionController extends Controller
{
	public function index (Request $request) {
		if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', $request->session()->get('searchtext', ''));
			
			if ($searchtext != '') {
				$request->session()->put('searchtext', $searchtext);
				$list = LqOption::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('lq_key', 'like', '%' . $searchtext . '%')
					->orWhere('lq_value', 'like', '%' . $searchtext . '%')
					->orWhere('notice', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$request->session()->remove('searchtext');
				$list = LqOption::orderby($sort, $direction)->paginate($length);
			}
			
			return view('admin.options.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
		
		return view('admin.options.index');
	}
	
	public function edit (Request $request, $id = 0) {
		$model = LqOption::findOrNew($id);
		
		if ($request->isMethod('post')) {
			// validator settings
			$niceNames = ['lq_key' => trans('admin.Kulcs'), 'lq_value' => trans('admin.Érték'), 'notice' => trans('admin.Megjegyzés')];
			$rules = ['lq_key' => 'required|unique:lq_options,lq_key,' . ($model->id ?: 0), 'lq_value' => 'required', 'notice' => ''];
			
			// validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_options_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('admin.Sikertelen mentés'),
					trans('admin.Az opció adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// data save
			$model->fill($request->all());
			$model->save();
			
			return redirect(route('admin_options_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('Sikeres mentés'),
				trans('Az opció adatai sikeresen rögzítve lettek.'),
			]);
		}
		
		return view('admin.options.edit', [
			'model' => $model
		]);
	}
	
	public function delete ($id) {
		if ($model = LqOption::find($id)) {
			$model->delete();
			return redirect(route('admin_options_list'))->with('form_success_message', [
				trans('admin.Sikeres törlés'),
				trans('admin.Az opció sikeresen el lett távolítva.')
			]);
		}
	}
}
