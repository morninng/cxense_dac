<meta charset="utf-8">

<?php

$username="cxense-team@dac.co.jp";
$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
$date = date("Y-m-d\TH:i:s.000O");
$signature=hash_hmac("sha256", $date, $apikey);

$url_content_fetch = 'https://api.cxense.com/profile/content/fetch';
$plainjson_payload_content_fetch = "{
		\"url\":\"http://m.dac.co.jp/group/field.html\",
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
echo($obj->{'url'});echo("<br>");
echo($obj->{'title'});echo("<br>");
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
		}
	}
	
	echo($thumbnail_url);echo("<br>");
	echo($thumbnail_width);echo("<br>");
	echo($thumbnail_height);echo("<br>");

echo("<br>");echo("<br>");
var_dump($obj);
?>
