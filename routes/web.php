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
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
	echo Hash::make('Hello world.');
    //return view('home');
});

Route::get('/category', 'CategoryController@index');

Route::prefix('account')->group(function () {
	Route::get('/register', function () {
	    return view('home');
	});

	Route::post('/register', function () {
	    return view('home');
	});

	Route::get('/recovery', function () {
	    return view('home');
	});

	Route::post('/recovery', function () {
	    return view('home');
	});

	Route::get('/login', function () {
	    return view('home');
	});

	Route::post('/login', function () {
	    return view('home');
	});

	Route::get('/logout', function () {
	    return view('home');
	});

	Route::get('/edit', function () {
	    return view('home');
	});

	Route::put('/update', function () {
	    return view('home');
	});

	Route::prefix('topics')->group(function () {
		Route::get('/', function () {
		    return view('home');
		});

		Route::get('/create', function () {
		    return view('home');
		});

		Route::post('/publish', function () {
		    return view('home');
		});

		Route::delete('/{id}/delete', function ($id) {
		    return view('home');
		});

		Route::get('/{id}/edit', function ($id) {
		    return view('home');
		});

		Route::put('/{id}/update', function ($id) {
		    return view('home');
		});

		Route::get('/{id}/reply', function ($id) {
		    return view('home');
		});

		Route::post('/{id}/reply/publish', function ($id) {
		    return view('home');
		});
	});
});

Route::prefix('user')->group(function () {
	Route::get('/{id}/profile', function ($id) {
	    return "Perfil do usuário {$id}.";
	});
});

Route::prefix('topics')->group(function () {
	Route::get('/', function () {
	    return view('home');
	});

	Route::get('/{id}/{slug}', function ($id, $slug) {
	    return view('home');
	});
});