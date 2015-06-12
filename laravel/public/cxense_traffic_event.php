
<meta charset="utf-8">

<?php


		$url_array = array();

		$keyword = "dac";
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/traffic/event';

		echo("signature  :" . $signature); echo("<br><br>");
		$plainjson_payload = "{\"siteId\":\"1128275557251903601\",
                     		   \"start\":\"-86400\", 
							   \"groups\":[\"url\"],
							   \"count\":20,
				 \"filters\":[{\"type\":\"keyword\",\"group\":\"concept\", \"item\":\"$keyword\"}]
								}";

		echo("payload  :" . $plainjson_payload);echo("<br><br>");

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
			echo($url . "<br>");
			array_push($url_array, $url );
		}

		echo("<br>obj<br>");
		var_dump($obj);
		echo("<br>result<br>");
		var_dump($result_traffic_event);

		return $url_array;


?>