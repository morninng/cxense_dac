<?PHP
header("Content-Type: application/json; charset=utf-8");


	function setCxenseFirstpartyData($obj)
	{
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/profile/user/external/update';
		$plainjson_payload = json_encode($obj);;
		echo $plainjson_payload;

		echo '---plainjson_payload--';

		$request_data = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload,
		    ),
		);
		echo '-------';
		echo 'request data';
		echo '-------';
		var_dump($request_data);

		echo 'before context';

		$context  = stream_context_create($request_data);
		echo '-------';
		echo 'context';
		echo '-------';
		var_dump($context);

		
		$result = file_get_contents($url, false, $context);

		var_dump($result);

	}


	function test($obj){
		echo 'test';
		var_dump($obj);
	}



 $id = $_POST['id']; 
 var_dump( $id);
 echo '-------';

 $segments_str = $_POST['segments']; 
 var_dump($segments_str);
 echo '-------';

 $segments_array = preg_split("/,/", $segments_str);
 var_dump($segments_array);
  echo '-------';
 $seg_obj_array = array();
 
foreach( $segments_array as $segment ){
	$segment_obj = array( 'group' => "dac-aoneseg",'item' => $segment );
 	var_dump($segment_obj);
	array_push($seg_obj_array, $segment_obj);
}
 echo '-----seg obj array--';
 
 var_dump($seg_obj_array);


 echo '-------';

$user_seg_obj = array( 'id' => $id,'type' => "dac", 'profile' => $seg_obj_array );

 echo '-------';

 var_dump( $user_seg_obj );

test($user_seg_obj);

/*
setCxenseFirstpartyData($user_seg_obj )
*/
 setCxenseFirstpartyData($user_seg_obj);









?>