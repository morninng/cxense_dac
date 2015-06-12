
<meta charset="utf-8">
<?php
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/profile/user/segment';

//		$plainjson_payload = "{\"identities\":[{\"id\": \"i9o0vhdj79hzrhh9\",\"type\": \"cx\"}],
//							   \"siteGroupIds\":[\"1128282190931682955\"]}";

		$plainjson_payload = "{\"id\":\"ia7kyhv5cc6vf1wd\",
							   \"type\": \"cx\",
							   \"siteGroupIds\":[\"1128282190931682955\"]}";
		echo("payload  :" . $plainjson_payload);
		echo("<br><br>");

		$options = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload,
		    ),
		);
		var_dump($options);echo("<br><br>");
		$context  = stream_context_create($options);
		var_dump($context);echo("<br><br>");
		var_dump($url);echo("<br><br>");
		$result_user_segment   = file_get_contents($url, false, $context);
	
		echo("----------result user segment------</br>");
		var_dump($result_user_segment);

		$obj = json_decode($result_user_segment);
		echo("----------obj------</br>");
		var_dump($obj);

		echo("----------------</br>");

?>
