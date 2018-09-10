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



Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');


Auth::routes();

Route::get('/auth/facebook', 'SocialAuthController@facebook');
Route::get('/auth/facebook/callback', 'SocialAuthController@callback');
Route::post('/auth/facebook/register', 'SocialAuthController@register');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::post('/users/{username}/dms', 'UsersController@sendPrivateMessage');
    Route::post('/users/{username}/follow', 'UsersController@follow');
    Route::post('/users/{username}/unfollow', 'UsersController@unfollow');
    Route::get('/conversations/{conversation}', 'UsersController@showConversations');
});

Route::resource('messages', 'MessagesController');
Route::get('messages', 'MessagesController@search');

Route::resource('users', 'UsersController');
Route::get('/users/{username}/follows', 'UsersController@follows');
Route::get('/users/{username}/followers', 'UsersController@followers');


# Api
Route::middleware(['auth'])->group(function () {
    Route::get('/api/notifications', 'UsersController@notifications');
});
Route::get('/api/messages/{message}/responses', 'MessagesController@responses');


