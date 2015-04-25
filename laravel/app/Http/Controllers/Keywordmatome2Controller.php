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

class Keywordmatome2Controller extends Controller {

	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public $login_status = 0;
	
	public function __construct(){

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
	 * @return Response
	 */
	public function index()
	{
		$domain_press = "http://www.dac.co.jp/press";
		$html_context = file_get_html($domain_press);
		$title_context = "<h1 class='pageTitle'>トレンドキーワード別の人気ページ</h1>";
	//	$article_context = $keyword;

		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);

	//	$url_array = $this->traffic_event($keyword);

		return view('keywordmatome2')
				->with("title_context",$title_context)
			//	->with("article_context",$article_context)
				->with("login_status",$this->login_status)
				->with("leftbar_context",$leftbar_context_converted);
	}

	private function traffic_event($keyword)
	{
		$url_array = array();

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/traffic/event';

		$plainjson_payload = "{\"siteId\":\"1128275557251903601\",
                     		   \"start\":\"-86400\", 
							   \"groups\":[\"url\"],
							   \"count\":20,
		\"filters\":[{\"type\":\"keyword\",\"group\":\"concept\", \"item\":\"$keyword\"}]
								}";
		$options = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload,
		    ),
		);
		$context  = stream_context_create($options);
		$result_traffic_event   = file_get_contents($url, false, $context);
		$obj = json_decode($result_traffic_event);
		$items_array = $obj->{'groups'}[0]->{'items'};

		foreach($items_array as  $item ){
			$url = $item->{'item'};
			array_push($url_array, $url );
		}
		return $url_array;
	}
}
