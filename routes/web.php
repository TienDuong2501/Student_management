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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::group(['middleware' => 'auth'], function() {
	Route::resource('users', 'UserController');
	Route::resource('homeworks', 'HomeWorkController');
	Route::get('homeworks/download/{homework}', 'HomeWorkController@download')->name('homeworks.download');
	Route::resource('done_homeworks', 'DoneHomeWorkController');
	Route::resource('comments', 'CommentController');
	Route::resource('games', 'GameController');
	Route::get('play-game/{game}', 'GameController@showGame')->name('games.show_game');
	Route::post('play-game/{game}', 'GameController@play')->name('games.play_game');
});
