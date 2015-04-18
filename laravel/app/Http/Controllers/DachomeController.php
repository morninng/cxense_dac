<?php 
namespace App\Http\Controllers;

//require_once 'Benchmark/Timer.php';

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

class DachomeController extends Controller {
	/**
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

	private function get_signature(){
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		return $signature;
	}

	public function cxense_dac_site_concept()
	{
		$signature = $this->get_signature();
		$date = date("Y-m-d\TH:i:s.000O");
		$username="cxense-team@dac.co.jp";
		$url = 'https://api.cxense.com/traffic/keyword';
		$plainjson_payload = "{\"siteId\":\"1128275557251903601\", 
								\"start\":\"-86400\", 
								\"historyResolution\":\"minute\"}";
		$options = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload,
		    ),
		);
		$context  = stream_context_create($options);
		$result_traffic_keyword = file_get_contents($url, false, $context);
		$obj = json_decode($result_traffic_keyword );

		$concept_array = array();
		$groups =  $obj->{'groups'};
		foreach($groups as  $group ){
			if($group->{'group'} == "concept"){
				$concept_items = $group->{'items'};
				foreach($concept_items as  $item ){
					array_push($concept_array, $item->{'item'} );
				}
			}
		}
		return $concept_array;
	}

	/**
	 * @return Response
	 */
	public function index()
	{
//$timer2 = new \Benchmark_Timer(TRUE);
//$timer2->setMarker('parse init start');

		$domain_home = "http://www.dac.co.jp/";
		$html_context = file_get_html($domain_home);
//$timer2->setMarker('html context get');

		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);

		$article_context = $html_context->find('article')[0];
		$article_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $article_context);
		$site_concept_array = $this->cxense_dac_site_concept();
//$timer2->setMarker('cxense site concept done');
//$timer2->stop();
//$timer2->display();
		return view('dachome')
				->with("left_area_context",$leftbar_context_converted)
				->with("article_context",$article_context_converted)
				->with("site_concept_array",$site_concept_array)
				->with("login_status",$this->login_status);
	}
}
