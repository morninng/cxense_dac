<?php namespace App\Http\Controllers;

class SolutionController extends Controller {


	/**
	 * Create a new controller instance.
	 * @return void
	 */
	public function __construct()
	{
	}

	/**
	 * Show the application dashboard to the user.
	 * @return Response
	 */

	public function show_user_data_bikebros($user_parse_id)
	{
		$bikebros_cxense_id = "1130531920128972215";
		
		$user_profile_array = $this->retrieve_user_data($bikebros_cxense_id, $user_parse_id);
		$user_traffic_keyword_array = $this->retrieve_profile_from_traffic_keyword($bikebros_cxense_id, $user_parse_id);
		$user_traffic_event_array = $this->retrieve_profile_from_traffic_event($bikebros_cxense_id, $user_parse_id);

		
		return view('userdata_show')
				->with("user_parse_id",$user_parse_id)
				->with("user_traffic_keyword_array",$user_traffic_keyword_array)
				->with("user_traffic_event_array",$user_traffic_event_array)
				->with("user_profile_array",$user_profile_array)
				->with("cxense_site_id",$bikebros_cxense_id);
	}

	public function show_user_data_dac($user_parse_id)
	{
		$dac_cxense_id = "1128275557251903601";
		$widget_id = "1f951bcaf311a3e5ccf9e0e908c4773cb076d3e0";
		$url = "http://www.dac.co.jp";
		
		$user_profile_array = $this->retrieve_user_data($dac_cxense_id, $user_parse_id);
		$user_traffic_keyword_array = $this->retrieve_profile_from_traffic_keyword($dac_cxense_id, $user_parse_id);
		$user_traffic_event_array = $this->retrieve_profile_from_traffic_event($dac_cxense_id, $user_parse_id);
	//	$user_content = $this->retrieve_content($dac_cxense_id,$widget_id, $user_parse_id, $url);

		return view('userdata_show')
				->with("user_parse_id",$user_parse_id)
				->with("user_profile_array",$user_profile_array)
				->with("user_traffic_keyword_array",$user_traffic_keyword_array)
				->with("user_traffic_event_array",$user_traffic_event_array)
				->with("cxense_site_id",$dac_cxense_id);

	}

	public function bikebros_redirect($user_parse_id)
	{

		$bikebros_cxense_id = "1130531920128972215";
		$redirect_url = "/solution_dac_redirect/" . $user_parse_id;

		return view('userdata_redirect')
				->with("user_parse_id",$user_parse_id)
				->with("redirect_url",$redirect_url)
				->with("cxense_site_id",$bikebros_cxense_id);
	}

	public function dac_redirect($user_parse_id)
	{
		$dac_cxense_id = "1128275557251903601";
		$redirect_url = "/show_user_data_dac/" . $user_parse_id;

		return view('userdata_redirect')
				->with("user_parse_id",$user_parse_id)
				->with("redirect_url",$redirect_url)
				->with("cxense_site_id",$dac_cxense_id);
	}

	public function people_list()
	{
		return view('solution_home');
	}


	public function retrieve_user_data($cxense_id, $user_parse_id){

		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/profile/user';

		$plainjson_payload = "{\"id\":\"$user_parse_id\", \"type\":\"dac\" }";
		$options = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload,
		    ),
		);
		$context  = stream_context_create($options);
		$user_profile   = file_get_contents($url, false, $context);
		$obj = json_decode($user_profile);
		$user_profile_array = $obj->{'profile'};
/*use
		foreach ($user_profile_array as $user_profile){

			$user_item = $user_profile->{'item'};
			$user_group_array = $user_profile->{'groups'};
			echo "user item is <strong>" . $user_item . "</strong><br>";
			foreach ($user_group_array as $user_group){
			//	$count =  $user_group->{'count'};
			//	echo "count is " . $count . "<br>";
				$group =  $user_group->{'group'};
				echo "group is " . $group . "<br>";
				$weight =  $user_group->{'weight'};
				echo "weight is " . $weight . "<br>";
			}
			echo "<br>";
			echo "<br>";
			echo "<br>";
		}
*/
		echo "object retrieved by profile/user/";
		echo "<br>";
		echo "parse id used is " . $user_parse_id . "<br>";
		echo "cxense id used is " . $cxense_id;

		return $user_profile_array;
	}
	
	
	public function retrieve_profile_from_traffic_keyword($cxense_id, $user_parse_id){
	
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/traffic/keyword';

		$plainjson_payload = "{\"siteId\":\"$cxense_id\"
					, \"filters\":[{\"type\":\"user\", \"group\":\"dac\", \"item\":\"$user_parse_id\"}]
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
		$user_traffic_keyword   = file_get_contents($url, false, $context);
		$obj = json_decode($user_traffic_keyword);
		$groups_array = $obj->{'groups'};
/*
		 var_dump($groups_array);

		
		echo '<br>traffic keyword<br>';
		var_dump($obj);
		echo '<br>group<br>';
		//var_dump($obj->{'groups'});
		echo '<br>-----------------<br>';
		foreach ($groups_array as $group){
			echo '<br>items array<br>';
			$group_group = $group->{'group'};
		//	print($group_group);
			echo '<br>';
			$group_data = $group->{'data'};
		//	var_dump($group_data );
			echo '<br>';
			$group_items_array = $group->{'items'};
			var_dump($group_items_array );
			foreach ($group_items_array as $group_item){
				echo 'group item <br>';
				var_dump($group_item);
				$item = $group_item->{'item'};
				echo '<br>';
				echo 'item is ';
				print($item);
				$item_weight = $group_item->{'data'}->{'weight'};
				echo '<br>';
				echo 'item_weight is ';
				var_dump($item_weight);
				echo '<br><br>';
			}
			echo '<br><br>';
		}

*/

		return $groups_array;

	}





	public function retrieve_profile_from_traffic_event($cxense_id, $user_parse_id){
	
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/traffic/event';

		$plainjson_payload = "{\"siteId\":\"$cxense_id\"
					, \"filters\":[{\"type\":\"user\", \"group\":\"dac\", \"item\":\"$user_parse_id\"}]
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
		$user_traffic_event   = file_get_contents($url, false, $context);
		$obj = json_decode($user_traffic_event);
		$groups_array = $obj->{'groups'};
/*
		echo '<br>traffic event<br>';
		var_dump($obj);


		echo '<br>traffic keyword<br>';
		var_dump($obj);
		echo '<br>group<br>';
		var_dump($obj->{'groups'});
		echo '<br>-----------------<br>';
		foreach ($groups_array as $group){
			echo '<br>items array<br>';
			$group_group = $group->{'group'};
			print($group_group);
			echo '<br>';
			$group_items_array = $group->{'items'};
			var_dump($group_items_array );
			foreach ($group_items_array as $group_item){
				var_dump($group_item);
				$item = $group_item->{'item'};
				echo '<br>';
				echo 'item is ';
				print($item);
				echo '<br><br>';
			}
			echo '<br><br>';
		}
*/
		return $groups_array;

	}



	public function retrieve_content($cxense_id, $widget_id, $user_parse_id, $page_url){

		echo "<br>retrieve content<br>";

		$api_url = 'http://api.cxense.com/public/widget/data';
		$Page_Url_obj  = array(
		    'url' => $page_url
		);
		$Usi  = array(
		    'usi' => 'dac'
		);
		$User_ID  = array(
		    'ids' => $Usi
		);
		$POST_DATA = array(
		    'widgetId' => $widget_id,
		    'user' => $User_ID,
		    'context' => $Page_Url_obj
		);
		echo "<br><strong>post data</strong><br>";
		var_dump($POST_DATA);

		echo "<br><strong>query</strong><br>";
		$query = http_build_query($POST_DATA);
		var_dump($query );

		echo "<br><strong>execution</strong>";
		$curl=curl_init($api_url);
		curl_setopt($curl,CURLOPT_POST, TRUE);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($POST_DATA));
		curl_setopt($curl, CURLOPT_HEADER, true); // ヘッダも出力したい場合
	    $info = curl_getinfo($curl);
		echo "<br>";
		$output= curl_exec($curl);
		echo "<br><strong>header info</strong><br>";
		var_dump($info);

		echo "<br><strong>output</strong><br>";
		var_dump($output);

	}

}
