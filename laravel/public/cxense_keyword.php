
<meta charset="utf-8">

<?php


$username="cxense-team@dac.co.jp";
$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
$date = date("Y-m-d\TH:i:s.000O");
$signature=hash_hmac("sha256", $date, $apikey);
$url = 'https://api.cxense.com/traffic/keyword';

$plainjson_payload = "{\"siteId\":\"1128275557251903601\", \"start\":\"-86400\", \"historyResolution\":\"minute\"}";


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
			echo($item->{'item'});echo("<br>");
			array_push($concept_array, $item->{'item'} );

		}
	}
}
foreach($concept_array as $test){
	echo($test."<br>");
}

var_dump($result_traffic_keyword);
?>
