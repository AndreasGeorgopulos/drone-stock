<?php

// Admin felhasználó controller

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Role_User;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // felhasználó kezelő oldal
    public function index (Request $request) {
    	if ($request->isMethod('post')) {
			$length = $request->get('length', config('adminlte.paginator.default_length'));
			$sort = $request->get('sort', 'id');
			$direction = $request->get('direction', 'asc');
			$searchtext = $request->get('searchtext', '');
			
			if ($searchtext != '') {
				$list = User::where('id', 'like', '%' . $searchtext . '%')
					->orWhere('name', 'like', '%' . $searchtext . '%')
					->orWhere('email', 'like', '%' . $searchtext . '%')
					->orderby($sort, $direction)
					->paginate($length);
			}
			else {
				$list = User::orderby($sort, $direction)->paginate($length);
			}
			
			return view('admin.users.list', [
				'list' => $list,
				'sort' => $sort,
				'direction' => $direction,
				'searchtext' => $searchtext
			]);
		}
		
        return view('admin.users.index');
    }
    
    public function edit (Request $request, $id = 0) {
    	// model
    	$model = User::findOrNew($id);
    	
    	// tabs
    	$tabs = [
    		['href' => 'general_data', 'title' => trans('admin.Általános adatok'), 'include' => 'admin.users.tab_general']
		];
    	if ($model->id) {
    		// check user roles
    		if (Auth::user()->roles()->where('key', 'superadmin')->orWhere('key', 'roles')->first()) {
				$tabs[] = ['href' => 'role_data', 'title' => trans('admin.Jogosultágok'), 'include' => 'admin.users.tab_roles'];
			}
		}
		else {
    		$model->active = 1;
		}
  
		// post request
    	if ($request->isMethod('post')) {
    		// validator settings
			$niceNames = array(
				'email' => trans('admin.E-mail cím'),
				'name' => trans('admin.Név'),
				'password' => trans('admin.Jelszó'),
				'password_confirmation' => trans('admin.Jelszó megerősítése'),
			);
			
    		$rules = [
    			'email' => 'required|email|unique:users,email,' . $model->id,
				'name' => 'required',
				'password' => !$model->id || $request->get('password') ? 'required|min:6|confirmed' : '',
				'password_confirmation' => !$model->id || $request->get('password') ? 'required|min:6' : '',
				'active' => ''
			];
    		
    		// form data validate
			$validator = Validator::make($request->all(), $rules);
			$validator->setAttributeNames($niceNames);
			if ($validator->fails()) {
				return redirect(route('admin_users_edit', ['id' => $id]))->withErrors($validator)->withInput()->with('form_warning_message', [
					trans('admin.Sikertelen mentés'),
					trans('admin.A felhasználó adatainak rögzítése nem sikerült a következő hibák miatt:')
				]);
			}
			
			// form data save
			$model->fill($request->all());
			$model->save();
			
			// role settings save
			// check user roles
			if (Auth::user()->roles()->where('key', 'superadmin')->orWhere('key', 'roles')->first()) {
				Role_User::where('user_id', $model->id)->delete();
				foreach ($request->get('roles', []) as $role_id) {
					$role_user = new Role_User();
					$role_user->role_id = $role_id;
					$role_user->user_id = $model->id;
					$role_user->save();
				}
			}
		
			return redirect(route('admin_users_edit', ['id' => $model->id]))->with('form_success_message', [
				trans('admin.Sikeres mentés'),
				trans('admin.A felhasználó adatai sikeresen rögzítve lettek.')
			]);
		}

		return view('admin.users.edit', [
			'model' => $model,
			'tabs' => $tabs,
			'roles' => Role::all()
		]);
	}
	
	public function delete ($id) {
		if ($user = User::find($id)) {
			if (!$user->roles()->where('key', 'superadmin')->first()) {
				$user->delete();
				
				return redirect(route('admin_users_list'))->with('form_success_message', [
					trans('admin.Sikeres törlés'),
					trans('admin.A felhasználó sikeresen el lett távolítva.')
				]);
			}
			else {
				return redirect(route('admin_users_list'))->with('form_warning_message', [
					trans('admin.Sikerestelen törlés'),
					trans('admin.A felhasználó nem törölhető, mert superadmin jogosultsággal rendelkezik.')
				]);
			}
		}
	}
	
	public function forceLogin ($id) {
    	if ($user = User::find($id)) {
    		Auth::login($user);
    		return redirect('/');
		}
	}
}
