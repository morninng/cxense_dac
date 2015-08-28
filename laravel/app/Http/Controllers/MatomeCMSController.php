<?php namespace App\Http\Controllers;


	require_once(app_path().'/Http/Controllers/opengraph-master/OpenGraph.php');
	//include(app_path().'/Http/Controllers/lib/simple_html_dom.php');

class MatomeCMSController extends Controller {



//	public $cxense_siteid = "1128275557251903601"; //DAC
	public $cxense_siteid = "1130531920128972215"; //bikebros
//	public $cxense_siteid = "1128278396013753941"; //excite
//	public $cxense_siteid = "1129413447655459563"; //tv tokyo

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function cms_publisher_list()
	{
		return view('home');
	}

	public function cms_keyword_list()
	{

	//	echo '<meta charset="utf-8">';

		$keyword_array = $this->retrieve_traffic_keyword();

		return view('matome_keywordlist')
				->with("keyword_array",$keyword_array);
	}


	public function matome_site_link()
	{

		return view('matome_site_link');
	}




	public function cms_site_list()
	{
		echo '<meta charset="utf-8">';
		$param = $_GET['keyword'];
//		echo $param;
		$keywords_array = explode("_", $param);
//		var_dump($keywords_array);


		$matome_data_object_array = array();

		foreach ($keywords_array as $j => $keyword_value){

		//	echo '<h2> kayword is ' . $keyword_value .'</h2>';
			$url_list_array = $this->RetrieveURL_list_traffic_event($keywords_array[$j]);
			//var_dump($url_list);

			$list_urldata_for_one_keyword = array();

			foreach ($url_list_array as $i => $value){

				// echo "<br>" . $value;
				$url_related_data = new \stdClass();

				$url_related_data->{'url'} = $value;
				$url_related_data->{'title'} = "";
				$url_related_data->{'image'} = "";
				$url_related_data->{'description'} = "";
				$url_related_data->{'site_name'} = "";


				$traffic_data = $this->retrieve_traffic($url_list_array[$i]);
				foreach($traffic_data as $g_i => $g_value){
					$url_related_data->{$g_i} = $g_value;
				}


/*
				echo '<br>traffic data <br>';
				var_dump($traffic_data );
*/
				var_dump($url_list_array[$i]);
				$graph = \OpenGraph::fetch($url_list_array[$i]); 

				//var_dump($graph);
				if($graph){
					foreach($graph as $g_i => $g_value){
						$url_related_data->{$g_i} = $g_value;
					}
				}
/*
				echo '<br>graph data <br>';
				var_dump($graph );

				$title = $graph->{'title'};
				echo "title" . $title . "<br>";
				$description = $graph->{'description'};
				echo "description" . $description . "<br>";
				$image = $graph->{'image'};
				echo "image" . $image . "<br>";
				$type = $graph->{'type'};
				echo "type" . $type . "<br>";
				$site_name = $graph->{'site_name'};
				echo "site name" . $site_name . "<br>";
*/
			//	$connected_data = array_merge((array)$traffic_data , (array)$graph);

				array_push($list_urldata_for_one_keyword, $url_related_data);
			}
			$obj = [ "keyword" => $keyword_value, "list_data" => $list_urldata_for_one_keyword];
			array_push($matome_data_object_array, $obj);
		}
	//	var_dump($matome_data_object_array);

		return view('matome_url_context')
				->with("matome_data_object_array",$matome_data_object_array);
	}



	public function matome_site($keyword)
	{


		return view('matome_site')
			->with("keyword",$keyword );
	}




	public function RetrieveURL_list_traffic_event($keyword)
	{
		$url_array = array();

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/traffic/event';

		$plainjson_payload = "{\"siteId\":\"$this->cxense_siteid\",
							   \"groups\":[\"url\"],
							   \"count\":3,
							   \"fields\":[\"activeTime\"],
							   \"orderBy\":\"activeTime\",
		\"filters\":[{\"type\":\"keyword\",\"group\":\"concept\", \"item\":\"$keyword\"},
					{\"type\":\"keyword\", \"group\":\"pageclass\", \"item\":\"article\"}]
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




	public function retrieve_profile_content_fetch($site_url)
	{

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);

		$url_content_fetch = 'https://api.cxense.com/profile/content/fetch';
		$plainjson_payload_content_fetch = "{
				\"url\":\"$site_url\",
				\"groups\":[\"url\",\"title\",\"thumbnails\",\"referrerUrl\",\"referrerSocialNetwork\",\"referrerSearchEngine\"]
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
		echo '<br>a<br>';
	//	var_dump($obj);
		echo '<br>b<br>';
		$thumbnail_array = $obj->{'thumbnails'};

		$thumbnail_width = 0;
		$thumbnail_height = 0;
		$thumbnail_url = null;
		$thumbnail_array = array();

		if($obj->{'thumbnails'}){
			$thumbnail_array = $obj->{'thumbnails'};
		}


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



	public function retrieve_traffic_keyword()
	{

		$keyword_array = array();

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/traffic/keyword';


		$plainjson_payload = "{
						\"siteId\":\"$this->cxense_siteid\",
                     	\"count\":\"1000\",
						\"groups\":[
							\"concept\",
							\"company\"
						]
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
		$result_traffic_keyword   = file_get_contents($url, false, $context);
		$obj = json_decode($result_traffic_keyword);
		$groups_array = $obj->{'groups'};
		foreach ($groups_array as $group){
			$group_items_array = $group->{'items'};
			foreach ($group_items_array as $group_item){
				$item = $group_item->{'item'};
			//	echo '<br>';
			//	print($item);
				array_push($keyword_array, $item);
			}
		}
		// var_dump($keyword_array);

		return $keyword_array;
		
	}



	public function retrieve_traffic($url_measured)
	{

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url_traffic = 'https://api.cxense.com/traffic';

		$plainjson_payload_traffic = "{
				\"siteId\":\"$this->cxense_siteid\",
				\"fields\":[\"uniqueUsers\",\"activeTime\",\"urls\",\"events\",\"urls\",\"sessionBounces\"],
				\"filters\":[{\"type\":\"event\",\"group\":\"url\", \"item\":\"$url_measured\"}]
				}";


		$options_traffic = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload_traffic,
		    ),
		);


		$context_traffic  = stream_context_create($options_traffic);
		$result_traffic = file_get_contents($url_traffic, false, $context_traffic);

		$obj = json_decode($result_traffic );
	//	echo "<br> --- traffic event info<br>";
		$traffic_data = $obj->{'data'};
/*
		var_dump($traffic_data);
		echo "<br>";
		$traffic_pv = $traffic_data->{'events'};
		echo "pv " . $traffic_pv . "<br>";
		$traffic_uu = $traffic_data->{'uniqueUsers'};
		echo "uu " . $traffic_uu . "<br>";
		$traffic_active_time = $traffic_data->{'activeTime'};
		echo "active time " . $traffic_active_time . "<br>";
		$traffic_bounce = $traffic_data->{'sessionBounces'};
		echo "traffic bounce " . $traffic_bounce . "<br>";
*/
		return $traffic_data;
	}


}
