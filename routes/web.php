<?php

	/*
	|--------------------------------------------------------------------------
	| Web Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register web routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| contains the "web" middleware group. Now create something great!
	|
	*/

	Auth ::routes();

	Route ::get('/', 'PagesController@index');
	Route ::get('/about', 'PagesController@about');
	Route ::get('/services', 'PagesController@services');

	Route ::get('/home', function() {
		return redirect('/');
	});

	Route ::post('reviews', 'KiosksController@storeReview');
	Route ::delete('reviews/{id}', 'KiosksController@destroyReview');
	Route ::resource('kiosks', 'KiosksController');
	Route ::get('/dashboard', 'DashboardController@index');