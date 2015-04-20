
<meta charset="utf-8">

<?php

$keyword = "dac";
$username="cxense-team@dac.co.jp";
$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
$date = date("Y-m-d\TH:i:s.000O");
$signature=hash_hmac("sha256", $date, $apikey);
$url = 'https://api.cxense.com/traffic';

$plainjson_payload = "{\"siteId\":\"1128275557251903601\",
                       \"start\":\"-864000\", 
                       \"fields\":[\"events\",\"urls\",\"activeTime\"],
                       \"filters\":[
                         {\"type\":\"keyword\",\"group\":\"site\", \"item\":\"dac.co.jp\"}
                         ]
                   }";
//echo($plainjson_payload);

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

 echo("aa  bb<br>");
var_dump($obj);
$number_PV = $obj->{'data'}->{'events'};
//echo($number_PV);echo("<br>");

 echo("aa<br>");
$number_url = $obj->{'data'}->{'urls'};
echo($number_url);echo("<br>");

//var_dump($result_traffic_keyword);
 echo("aa<br>");
?>
