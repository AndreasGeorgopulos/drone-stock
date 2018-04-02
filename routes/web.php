<?php
$admin = function () {
	Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['locale', 'acl']], function() {
		Route::match(['get', 'post'], '/', 'IndexController@index')->name('admin_index');
		Route::match(['get', 'post'], '/login', 'IndexController@login')->name('admin_login');
		Route::match(['get', 'post'], '/logout', 'IndexController@logout')->name('admin_logout');
		Route::match(['get'], '/change_language/{locale}', 'IndexController@changeLanguage')->name('admin_change_language');
		
		// pages
		Route::match(['get', 'post'], '/contents/list', 'ContentController@index')->name('admin_contents_list');
		Route::match(['get', 'post', 'put'], '/contents/edit/{id?}', 'ContentController@edit')->name('admin_contents_edit');
		Route::match(['get'], '/contents/delete/{id?}', 'ContentController@delete')->name('admin_contents_delete');
		
		
		// pages
		Route::match(['get', 'post'], '/stock/list', 'StockController@index')->name('admin_stock_list');
		Route::match(['get', 'post', 'put'], '/stock/edit/{id?}', 'StockController@edit')->name('admin_stock_edit');
		Route::match(['get'], '/stock/delete/{id?}', 'StockController@delete')->name('admin_stock_delete');
		
		// users
		Route::match(['get', 'post'], '/users/list', 'UserController@index')->name('admin_users_list');
		Route::match(['get', 'post', 'put'], '/users/edit/{id?}', 'UserController@edit')->name('admin_users_edit');
		Route::match(['get'], '/users/delete/{id?}', 'UserController@delete')->name('admin_users_delete');
		Route::match(['get'], '/users/force_login/{id?}', 'UserController@forceLogin')->name('admin_users_force_login');
		
		// roles
		Route::match(['get', 'post'], '/roles/list', 'RoleController@index')->name('admin_roles_list');
		Route::match(['get', 'post', 'put'], '/roles/edit/{id?}', 'RoleController@edit')->name('admin_roles_edit');
		Route::match(['get'], '/roles/delete/{id?}', 'RoleController@delete')->name('admin_roles_delete');
		
		//Fordítások
		Route::match(['get'], '/translation/view/{group?}', 'TranslationController@getView')->name('admin_translation_getview');
		Route::match(['get'], '/translation/{group?}', 'TranslationController@getIndex')->name('admin_translation_getindex');
		Route::match(['post'], '/translation/add/{group}', 'TranslationController@postAdd')->name('admin_translation_postadd');
		Route::match(['post'], '/translation/edit/{group}', 'TranslationController@postEdit')->name('admin_translation_postedit');
		Route::match(['post'], '/translation/delete/{group}/{key}', 'TranslationController@postDelete')->name('admin_translation_postdelete');
		Route::match(['post'], '/translation/import', 'TranslationController@postImport')->name('admin_translation_postimport');
		Route::match(['post'], '/translation/find', 'TranslationController@postFind')->name('admin_translation_postfind');
		Route::match(['post'], '/translation/publish/{group}', 'TranslationController@postPublish')->name('admin_translation_postpublish');
		
	});
};

$delta_triangle = function() use ($admin) {
	$admin();
	Route::group(['namespace' => 'Domains\DeltaTriangle'], function() {
		Route::get('/', 'IndexController@index');
	});
};

$drone_stock = function() use ($admin) {
	$admin();
	Route::group(['namespace' => 'Domains\DroneStock'], function() {
		Route::get('/', 'IndexController@index');
	});
};

/*Route::domain('delta-triangle.com')->group($delta_triangle);
Route::domain('delta-triangle.hu')->group($delta_triangle);
Route::domain('drone-stock.com')->group($drone_stock);
Route::domain('drone-stock.hu')->group($drone_stock);*/

	
Route::domain('delta-triangle-com.local')->group($delta_triangle);
Route::domain('delta-triangle-hu.local')->group($delta_triangle);
Route::domain('drone-stock-com.local')->group($drone_stock);
Route::domain('drone-stock-hu.local')->group($drone_stock);