<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App;
use Illuminate\Support\Facades\Cookie;

class IndexController extends Controller
{
	use AuthenticatesUsers;
	
	protected $redirectTo = '/admin';
	
	public function index (Request $request) {
		return view(Auth::check() ? 'admin.dashboard' : 'admin.login');
	}
	
	public function logout () {
    	Auth::logout();
    	return redirect(route('admin_login'));
	}
	
	public function changeLanguage ($locale) {
		if (!in_array($locale, config('app.languages'))) {
			$locale = config('app.locale');
		}
		
		App::setLocale($locale);
		Cookie::queue(Cookie::make('locale', $locale, config('app.language_cookie_expires')));
		
		$referrer = request()->headers->get('referer') ?: '/admin';
		
		return redirect($referrer);
	}
}
