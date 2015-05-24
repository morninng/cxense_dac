<?php namespace App\Http\Controllers;

define( 'PARSE_SDK_DIR', './../vendor/parse/php-sdk/src/Parse/' );
require './../vendor/autoload.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
use Parse\ParseSessionStorage;

include(app_path().'/Http/Controllers/simple_html_dom.php');

class VideoController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return void
	 */

	public $login_status = 0;

	public function __construct()
	{
		session_start();
		ParseClient::initialize( 'ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o' 
								, 'b1qSJHLREpVGSWctgzaYFf2FBitfwgXE99B6un9B'
								, 'uO1sGxKOAIL3hydGNW8NmLXKYxIeKrpPbLtuVbnH' );
		$currentUser = ParseUser::getCurrentUser();
		if ($currentUser) {
		    $this->login_status = 1;
		} else {
		    $this->login_status = 0;
		}
	}

	/**
	 * Show the application dashboard to the user.
	 * @return Response
	 */

	public function index()
	{
		$domain_home = "http://www.dac.co.jp/";
		$html_context = file_get_html($domain_home);

		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);


		return view('video_home')
				->with("login_status",$this->login_status)
				->with("leftbar_context_converted",$leftbar_context_converted);
	}

	public function showVideo($media_id)
	{
		$domain_home = "http://www.dac.co.jp/";
		$html_context = file_get_html($domain_home);

		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);


		return view('video_each')
				->with("media_id",$media_id)
				->with("login_status",$this->login_status)
				->with("leftbar_context_converted",$leftbar_context_converted);
	}
}
