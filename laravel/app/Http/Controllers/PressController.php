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

class PressController extends Controller {

	/**
	 * Create a new controller instance.
	 *
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
	 *
	 * @return Response
	 */

	public function article_list()
	{
		$domain_press = "http://www.dac.co.jp/press";
		$html_context = file_get_html($domain_press);
		$title_context = $html_context->find(".pageTitle")[0];
		$article_context = $html_context->find("section")[0];
		$article_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $article_context);
		$article_context_converted2 = str_replace("<a href=\"http://www.dac.co.jp/", "<a href=\"/", $article_context_converted);


		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);

		return view('press')
				->with("title_context",$title_context)
				->with("login_status",$this->login_status)
				->with("article_context",$article_context_converted2)
				->with("leftbar_context",$leftbar_context_converted);
	}


	public function article($article_year, $article_context)
	{
		$domain_press = "http://www.dac.co.jp/press";
		$url = $domain_press .  "/" .$article_year . "/" . $article_context;
	//	$this->show_article($url);

		$html_context = file_get_html($url);
		$title_context = $html_context->find(".pageTitle")[0];
		$article_context = $html_context->find("section")[0];
		$article_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $article_context);
		$article_context_converted2 = str_replace("<a href=\"http://www.dac.co.jp/", "<a href=\"/", $article_context_converted);


		
		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);

		return view('press')
				->with("title_context",$title_context)
				->with("article_context",$article_context_converted2)
				->with("login_status",$this->login_status)
				->with("leftbar_context",$leftbar_context_converted);


	}

	private function extract_content_fetch($press_url)
	{
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);

		$url_content_fetch = 'https://api.cxense.com/profile/content/fetch';
		$plainjson_payload_content_fetch = "{\'url\':\'" . $press_url . "\'}";

		$options_content_fetch = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload_content_fetch,
		    ),
		);
		$context_content_fetch  = stream_context_create($options_content_fetch);
		$result_content_fetch = file_get_contents($url_content_fetch, false, $context_content_fetch);
	}
}
