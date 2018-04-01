<?php

$routes = [];
$routes['admin'] = function () {
	Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
		Route::get('/', 'IndexController@index')->name('admin-home');
	});
};

$routes['delta_triangle'] = function() use (&$routes) {
	$routes['admin']();
	Route::group(['namespace' => 'Domains\DeltaTriangle'], function() {
		Route::get('/', 'IndexController@index')->name('home');
	});
};

$routes['drone_stock'] = function() use (&$routes) {
	$routes['admin']();
	Route::group(['namespace' => 'Domains\DroneStock'], function() {
		Route::get('/', 'IndexController@index')->name('home');
	});
};

Route::domain('delta-triangle.com')->group($routes['delta_triangle']);
Route::domain('delta-triangle.hu')->group($routes['delta_triangle']);
Route::domain('drone-stock.com')->group($routes['drone_stock']);
Route::domain('drone-stock.hu')->group($routes['drone_stock']);