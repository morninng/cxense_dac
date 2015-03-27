<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//require_once 'simple_html_dom.php';

Route::get('/', 'WelcomeController@index');


/*
Route::get('/press/{article_id}', function($article_id)
{
	$press_id = $article_id;

    return View::make("press")->with("press_id",$press_id);
});
*/
Route::get('press/{article_year}/{article_context}', 'PressController@article');
Route::get('press/', 'PressController@article_list');

Route::get('/', 'DachomeController@index');

Route::get('/hello', function()
{
        return 'Hello World!!';
});

Route::get('home', 'HomeController@index');
Route::get('article', 'ArticleController@index');

Route::get('keyword_matome/{keyword}', 'KeywordmatomeController@index');
Route::get('keyword_matome2/{keyword}', 'Keywordmatome2Controller@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
