<?php namespace App\Http\Controllers;

define( 'PARSE_SDK_DIR', './../vendor/parse/php-sdk/src/Parse/' );
require './../vendor/autoload.php';

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

class ParseController extends Controller {

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
	public function index()
	{
		echo "parse test";

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
		return ;
	}
}
