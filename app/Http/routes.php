<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('pages.home');
    });

    // Authentication
    Route::get('auth/login', 'Auth\AuthController@showLoginForm');
    Route::post('auth/login', 'Auth\AuthController@login');
    Route::get('auth/logout', 'Auth\AuthController@logout');

    // Competitions
    Route::model('competitions', 'Gladiator\Models\Competition');
    Route::resource('competitions', 'CompetitionsController');

    // Waiting rooms routes.
    Route::model('waitingrooms', 'Gladiator\Models\WaitingRoom');
    Route::resource('waitingrooms', 'WaitingRoomsController');

});
