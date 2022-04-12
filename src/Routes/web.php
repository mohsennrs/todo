<?php

Route::group(['prefix'=>'tasks', 'as' => 'tasks.', 'namespace' => 'Hattori\ToDo\Controllers'],function(){

	Route::get('/', 'TaskController@index')->name('index');
	Route::post('/', 'TaskController@store')->name('store');
	Route::patch('/{id}', 'TaskController@update')->name('edit');
	Route::get('/{id}', 'TaskController@show')->name('show');

});

Route::group(['prefix'=>'labels', 'as' => 'labels.', 'namespace' => 'Hattori\ToDo\Controllers'],function(){

	Route::get('/', 'LabelController@index')->name('index');
	Route::post('/', 'LabelController@store')->name('store');
	Route::patch('/{id}', 'LabelController@update')->name('edit');
	Route::get('/{id}', 'LabelController@show')->name('show');

});

?>