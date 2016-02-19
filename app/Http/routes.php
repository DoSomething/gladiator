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

Route::get('/', function () {
    return view('pages.home');
});

Route::group(['middleware' => ['web']], function () {

    // Authentication
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    // Waiting rooms routes.
    Route::model('waitingrooms', 'Gladiator\Models\WaitingRoom');
    Route::resource('waitingrooms', 'WaitingRoomsController');

    // Competitions
    Route::resource('competitions', 'CompetitionsController');

});
