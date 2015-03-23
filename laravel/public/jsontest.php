
<?php

$json_test = '{"url":"http://ww.dac.co.jp",
	"id":"c08a74e320b",
	"profile":[{"item":"abaa","groups":[{"group":"location","weight":0.5290605}]},
	           {"item":"aaaa","groups":[{"group":"concept","weight":0.7299}]}
	           ]}';

$decoded_json = json_decode($json_test);

var_dump($decoded_json);
echo("<br><br>");

$url = $decoded_json->{'url'};
$profile_array = $decoded_json->{'profile'};
echo($url);echo("<br>");
echo($profile_array);echo("<br>");
var_dump($profile_array[0]);echo("<br>");
var_dump($profile_array[0]->{groups});echo("<br>");
$group = $profile_array[0]->{groups};echo("<br><br>");

var_dump($group);echo("<br><br>");
var_dump($group[0]->{"weight"});


?>
