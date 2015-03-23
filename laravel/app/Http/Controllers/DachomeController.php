<?php namespace App\Http\Controllers;

include(app_path().'/Http/Controllers/simple_html_dom.php');

class DachomeController extends Controller {

	/**
	 * @return void
	 */

	public function __construct(){}

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

	public function cxense_dac_site_traffic_keywordfilter($keyword, &$number_PV, &$number_url)
	{
		$signature = $this->get_signature();
		$date = date("Y-m-d\TH:i:s.000O");
		$username="cxense-team@dac.co.jp";
		$url = 'https://api.cxense.com/traffic';

		$plainjson_payload = "{\"siteId\":\"1128275557251903601\",
                       \"start\":\"-86400\", 
                       \"fields\":[\"events\",\"urls\",\"activeTime\"],
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
		$result_traffic_keyword = file_get_contents($url, false, $context);
		$obj = json_decode($result_traffic_keyword );

		$number_PV = $obj->{'data'}->{'events'};
		$number_url = $obj->{'data'}->{'urls'};

		return;
	}

	/**
	 * @return Response
	 */
	public function index()
	{
		$domain_home = "http://www.dac.co.jp/";
		$html_context = file_get_html($domain_home);

		$leftbar_context = $html_context->find('div[id=leftArea]')[0];
		$leftbar_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $leftbar_context);

		$article_context = $html_context->find('article')[0];
		$article_context_converted = str_replace("src=\"/", "src=\"http://www.dac.co.jp/", $article_context);

		$site_concept_array = $this->cxense_dac_site_concept();
		$site_concept_num_url_array = array();
		$site_concept_num_pv_array = array();
		$side_context = "";
		
		foreach($site_concept_array as $concept_keyword){
			$num_pv = 0;
			$num_url = 0;
			$this->cxense_dac_site_traffic_keywordfilter($concept_keyword, $num_pv, $num_url);
			
			array_push($site_concept_num_url_array, $num_url );
			array_push($site_concept_num_pv_array, $num_pv );
		}

		return view('dachome')
				->with("left_area_context",$leftbar_context_converted)
				->with("article_context",$article_context_converted)
				->with("site_concept_array",$site_concept_array)
				->with("site_concept_num_url_array",$site_concept_num_url_array)
				->with("site_concept_num_pv_array",$site_concept_num_pv_array);

	}
}
