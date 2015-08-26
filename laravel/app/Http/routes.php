<?php


//require_once 'simple_html_dom.php';

Route::get('/', 'WelcomeController@index');


Route::get('press/{article_year}/{article_context}', 'PressController@article');
Route::get('press/', 'PressController@article_list');

Route::get('/', 'DachomeController@index');
Route::get('video', 'VideoController@index');
Route::get('video/{media_id}', 'VideoController@showVideo');

Route::get('/hello', function()
{
        return 'Hello World!!';
});

Route::get('home', 'HomeController@index');
Route::get('article', 'ArticleController@index');
Route::get('parsepractice', 'ParseController@index');
Route::get('parseretrieve', 'ParseController@retrieve_object');

Route::get('keyword_matome/{keyword}', 'KeywordmatomeController@index');
Route::get('keyword_matome2', 'Keywordmatome2Controller@index');

Route::get('/parselogin','ParseauthController@getLogin');
Route::post('/parselogin','ParseauthController@postLogin');
Route::get('/parsesignin','ParseauthController@getSignin');
Route::post('/parsesignin','ParseauthController@postSignin');

// Route::post('/parsesignin',function(){return 'helloworld';});

Route::get('/parselogout', 'ParseauthController@getLogout');

Route::get('/editprofile', 'ParseauthController@editprofile');
Route::post('/editprofile', 'ParseauthController@post_editprofile');

Route::get('/solution_home/{user_parse_id}/', 'SolutionController@home');
Route::get('/solution_bikebros_redirect/{user_parse_id}', 'SolutionController@bikebros_redirect');
Route::get('/solution_dac_redirect/{user_parse_id}', 'SolutionController@dac_redirect');
Route::get('/solution_people_list', 'SolutionController@people_list');
Route::get('/show_user_data_dac/{user_parse_id}', 'SolutionController@show_user_data_dac');
Route::get('/show_user_data_bikebros/{user_parse_id}', 'SolutionController@show_user_data_bikebros');


Route::get('/matome_cms_publisherlist', 'MatomeCMSController@cms_publisher_list');
Route::get('/matome_cms_keywordlist', 'MatomeCMSController@cms_keyword_list');
Route::get('/matome_cms_sitelist', 'MatomeCMSController@cms_site_list');
Route::get('/matome_site_link', 'MatomeCMSController@matome_link');
Route::get('/matome_site/{keyword}', 'MatomeCMSController@matome_site');



Route::get('detail/{recipe_id}', 'ExciteController@detail');


Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

