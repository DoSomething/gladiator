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
        return redirect()->route('contests.index');
    });

    // Authentication
    Route::get('auth/login', 'Auth\AuthController@showLoginForm');
    Route::post('auth/login', 'Auth\AuthController@login');
    Route::get('auth/logout', 'Auth\AuthController@logout');

    // Competitions
    Route::model('competitions', 'Gladiator\Models\Competition');
    Route::get('competitions/{competitions}/export', 'CompetitionsController@export')->name('competitions.export');
    Route::resource('competitions', 'CompetitionsController', ['except' => ['index', 'create']]);
    Route::get('competition/{competition}/users/{user}', 'CompetitionsController@removeUser')->name('competitions.users.destroy');
    Route::get('competitions/{competitions}/messages/{contest}', 'CompetitionsController@message')->name('competitions.message');
    Route::get('competitions/{competitions}/leaderboard', 'CompetitionsController@leaderboard')->name('competitions.leaderboard');
    Route::get('competitions/{competition}/featured/{message}', 'CompetitionsController@featuredReportbackForm')->name('competitions.editFeatureReportback');
    Route::patch('competitions/{competition}/featured/{message}', 'CompetitionsController@updateFeaturedReportback')->name('competitions.updateFeaturedReportback');

    // Contests
    Route::model('contests', 'Gladiator\Models\Contest');
    Route::get('contests/{contest}/export', 'ContestsController@export')->name('contests.export');
    Route::get('/contests/{id}/messages/edit', 'MessagesController@edit')->name('contests.messages.edit');
    Route::get('contests/{contest}/signup', 'ContestsController@signupForm')->name('contests.user.add');
    Route::post('contests/{contest}/signup', 'ContestsController@signupUser')->name('contests.user.add');

    Route::match(['put', 'patch'], '/contests/{id}/messages', 'MessagesController@update')->name('contests.messages.update');
    Route::resource('contests', 'ContestsController');

    // Messages
    Route::resource('messages', 'MessagesController');
    Route::get('messages/{message}/send', 'MessagesController@sendMessage')->name('messages.send');

    // Settings
    Route::get('settings', 'Settings\SettingsController@index')->name('settings.index');
    Route::get('settings/{category}', 'Settings\SettingsController@indexCategory');
    Route::match(['put', 'patch'], 'settings/messages', 'Settings\MessagesSettingsController@update')->name('settings.messages.update');

    // Users
    Route::get('users/contestants', 'UsersController@contestantsIndex')->name('users.contestants');
    Route::resource('users', 'UsersController');
    Route::get('users/{id}/signup/{signup_id}', [
        'as' => 'users.signup',
        'uses' => 'UsersController@showSignup',
    ]);

    // Waiting rooms routes.
    Route::model('waitingrooms', 'Gladiator\Models\WaitingRoom');
    Route::get('waitingrooms/{waitingrooms}/export', 'WaitingRoomsController@export')->name('waitingrooms.export');
    Route::get('waitingrooms/{waitingrooms}/split', 'WaitingRoomsController@showSplitForm')->name('split');
    Route::post('waitingrooms/{waitingrooms}/split', 'WaitingRoomsController@split')->name('split');
    Route::resource('waitingrooms', 'WaitingRoomsController', ['except' => ['create', 'destroy']]);

});

Route::group(['prefix' => 'api/v1'], function () {

    Route::get('/', function () {
        return 'Gladiator API version 1';
    });

    Route::get('contests', 'Api\ContestsController@index');

    Route::get('users', 'Api\UsersController@index');
    Route::post('users', 'Api\UsersController@store');
});
