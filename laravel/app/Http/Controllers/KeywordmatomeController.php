<?php namespace App\Http\Controllers;

include(app_path().'/Http/Controllers/simple_html_dom.php');

class KeywordmatomeController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return void
	 */

	public function __construct(){}

	/**
	 * @return Response
	 */
	public function index()
	{
		$domain_press = "http://www.dac.co.jp/press";
		$html_context = file_get_html($domain_press);
		$title_context = "<h1 class='pageTitle'>トレンドキーワード別の人気ページ</h1>";
		$article_context = "広告効果測定";

		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);

		$url_array = $this->traffic_event();
		$link_array = [];

		foreach($url_array as $url){
			$link_content = $this->content_fetch($url);
		//	var_dump($url . "<br>");
			array_push($link_array, $link_content );
		}
	//	var_dump($link_array);


		return view('keywordmatome')
				->with("title_context",$title_context)
				->with("article_context",$article_context)
				->with("leftbar_context",$leftbar_context_converted)
				->with("link_array",$link_array)
				->with("url_array",$url_array);
	}

	private function traffic_event()
	{
		$url_array = array();

		$keyword = "広告効果測定";
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

	private function content_fetch($site_url){

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);

		$url_content_fetch = 'https://api.cxense.com/profile/content/fetch';
		$plainjson_payload_content_fetch = "{
				\"url\":\"$site_url\",
				\"groups\":[\"url\",\"title\",\"thumbnails\"]
				}";

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

		$obj = json_decode($result_content_fetch );
		$thumbnail_array = $obj->{'thumbnails'};

		$thumbnail_width = 0;
		$thumbnail_height = 0;
		$thumbnail_url = null;
		foreach($thumbnail_array as  $thumbnail ){
			$type = $thumbnail->{'type'};
			if($type == "dominant"){
				$thumbnail_width = $thumbnail->{'width'};
				$thumbnail_height = $thumbnail->{'height'};
				$thumbnail_url = $thumbnail->{'url'};
				if($thumbnail_width > 100){
					$thumbnail_width = 100;
					$thumbnail_height = (int)( $thumbnail_height * 100 /  $thumbnail->{'width'} );
				}
			}
		}

		$content_obj["thumbnail_url"] = $thumbnail_url;
		$content_obj["thumbnail_width"] = $thumbnail_width;
		$content_obj["thumbnail_height"] = $thumbnail_height;
		$content_obj["title"] = $obj->{'title'};
		$content_obj["url"] = $obj->{'url'};

		return $content_obj;

	}


}
