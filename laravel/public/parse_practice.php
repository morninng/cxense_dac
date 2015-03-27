

<?php 



define( 'PARSE_SDK_DIR', '/.vendor/Parse/' );

require 'vendor/autoload.php';

use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;




ParseClient::initialize( 'ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o' 
						, 'b1qSJHLREpVGSWctgzaYFf2FBitfwgXE99B6un9B'
						, 'uO1sGxKOAIL3hydGNW8NmLXKYxIeKrpPbLtuVbnH' );

$gameScore = new ParseObject("GameScore");
 
$gameScore->set("score", 1337);
$gameScore->set("playerName", "Sean Plott");
$gameScore->set("cheatMode", false);
 
try {
  $gameScore->save();
  echo 'New object created with objectId: ' . $gameScore->getObjectId();
} catch (ParseException $ex) {  
  echo 'Failed to create new object, with error message: ' + $ex->getMessage();
}




?>