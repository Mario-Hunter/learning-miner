<?php
use App\Events\CommentCreated;
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

Route::get('/redirect/{provider}', 'SocialAuthController@redirect');
Route::get('/callback/{provider}', 'SocialAuthController@callback');

Route::get('/redirect/google', 'SocialAuthController@gredirect');
Route::get('/callback/google', 'SocialAuthController@gcallback');

Route::get('/courses', 'CourseController@index');
Route::post('/courses', 'CourseController@store');
Route::get('/courses/page/{page}', 'CourseController@indexPage');

Route::get('/courses/create', 'CourseController@create');
Route::get('/courses/{course}', 'CourseController@show');
Route::delete('/courses/{course}', 'CourseController@delete');

Route::get('/courses/tags/{tag}','TagController@index');

Route::post('/courses/{course}/rank', 'RankController@store');

Route::post('/search', 'SearchController@set');
Route::get('/search/{course}/{page}', 'SearchController@show');

Route::post('/courses/{course}/comments','CommentController@store');

Route::get('/users/{user}','UserController@show');
Route::get('/user/{user}','UserController@showUserCourses');
Route::get('/userInfo/{user}','UserController@showUserInfo')->name('user_profile');
Route::post('/userInfo/{user}','UserController@update_avatar');

Route::post('/interest/{course}','InterestController@setStoreDelete');
Route::get('/interests/courses','InterestController@index');

Route::get('crawl/{query}','CrawlerController@crawl');

Route::post('/follow/{user}','FollowerController@follow');
Route::post('/follow/{user}','FollowerController@follow');
Route::get('/follow/followers/{user}','FollowerController@followers');
Route::get('/follow/following/{user}','FollowerController@following');
Route::get('/home', 'FollowerController@following');
