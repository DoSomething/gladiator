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

    Route::resource('competitions', 'CompetitionsController');

    // Waiting rooms routes.
    Route::model('waitingrooms', 'Gladiator\Models\WaitingRoom');
    Route::resource('waitingrooms', 'WaitingRoomsController');
});
