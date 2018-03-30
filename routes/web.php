<?php

$admin = function () {
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::get('/', 'IndexController@index')->name('admin-home');
    });
};

$delta_triangle = function() use ($admin) {
    $admin();
    Route::group(['namespace' => 'Domains\DeltaTriangle'], function() {
        Route::get('/', 'IndexController@index')->name('home');
    });
};

$drone_stock = function() use ($admin) {
    $admin();
    Route::group(['namespace' => 'Domains\DroneStock'], function() {
        Route::get('/', 'IndexController@index')->name('home');
    });
};

Route::domain('delta-triangle.com')->group($delta_triangle);
Route::domain('delta-triangle.hu')->group($delta_triangle);
Route::domain('drone-stock.com')->group($drone_stock);
Route::domain('drone-stock.hu')->group($drone_stock);