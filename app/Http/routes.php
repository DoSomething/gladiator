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

    // Users
    Route::model('users', 'Gladiator\Models\User');
    Route::resource('users', 'UsersController');
    Route::get('users/{id}/signup/{signup_id}', [
        'as' => 'users.signup',
        'uses' => 'UsersController@showSignup',
    ]);

    // Waiting rooms routes.
    Route::get('waitingrooms/{waitingrooms}/split', 'WaitingRoomsController@showSplitForm')->name('split');
    Route::post('waitingrooms/{waitingrooms}/split', 'WaitingRoomsController@split')->name('split');
    Route::model('waitingrooms', 'Gladiator\Models\WaitingRoom');
    Route::resource('waitingrooms', 'WaitingRoomsController');

});

Route::group(['prefix' => 'api/v1'], function () {

    Route::get('/', function () {
        return 'Gladiator API version 1';
    });

    Route::get('contests', 'Api\ContestsController@index');

    Route::get('users', function () {
        // @TODO: temporary, need to remove.
        return Gladiator\Models\User::all();
    });
    Route::post('users', 'Api\UsersController@store');

});
