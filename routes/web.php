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
    If(!Auth::guest())
        return redirect("/courses");
    return view('welcome');
});

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\RegisterController@confirm'
]);

Auth::routes();

Route::get('/redirect', 'SocialAuthController@redirect');
Route::get('/callback', 'SocialAuthController@callback');

Route::get('/home/{user}', 'HomeController@index');

Route::get('/courses', 'CourseController@index');
Route::post('/courses', 'CourseController@store');
Route::get('/courses/page/{page}', 'CourseController@indexPage');

Route::get('/courses/create', 'CourseController@create');
Route::get('/courses/{course}', 'CourseController@show');

Route::get('/courses/tags/{tag}','TagController@index');

Route::post('/courses/{course}/rank', 'RankController@store');

Route::post('/search', 'SearchController@set');
Route::get('/search/{course}', 'SearchController@show');

Route::post('/courses/{course}/comments','CommentController@store');

Route::get('/users/{user}','UserController@show');
Route::get('/user/{user}','UserController@showUserCourses');
Route::get('/userInfo/{user}','UserController@showUserInfo');
Route::post('/userInfo/{user}','UserController@update_avatar');

Route::get('/interest/{course}','InterestController@store');
Route::get('/interests/courses','InterestController@index');


Route::get('crawl/{query}','CrawlerController@crawl');

