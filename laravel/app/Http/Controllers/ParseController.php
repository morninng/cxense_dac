<?php namespace App\Http\Controllers;

define( 'PARSE_SDK_DIR', './../vendor/parse/php-sdk/src/Parse/' );
require './../vendor/autoload.php';



class ParseController extends Controller {

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

	/**
	 * Create a new controller instance.
	 * @return void
	 */

	public function __construct()
	{
				ParseClient::initialize( 'ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o' 
								, 'b1qSJHLREpVGSWctgzaYFf2FBitfwgXE99B6un9B'
								, 'uO1sGxKOAIL3hydGNW8NmLXKYxIeKrpPbLtuVbnH' );
	}

	/**
	 * Show the application dashboard to the user.
	 * @return Response
	 */
	public function index()
	{
		echo "parse test";


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



	public function retrieve_object()
	{
		$query = new ParseQuery("GameScore");
		try {
		  $gameScore = $query->get("JWFbucIpL2");
		  echo $gameScore->get("playerName") . "<br>";
		  echo $gameScore->get("score") . "<br>";
		  
		  echo date_format($gameScore->getUpdatedAt(), 'Y-m-d H:i:s') . "<br>";
		  echo date_format($gameScore->getCreatedAt(), 'Y-m-d H:i:s') . "<br>";

		  echo $gameScore->get("cheatMode") . "<br>";
		  echo $gameScore->getObjectId() . "<br>";
		  // The object was retrieved successfully.
		} catch (ParseException $ex) {
		  // The object was not retrieved successfully.
		  // error is a ParseException with an error code and message.
		}
		$gameScore->increment("score");
		try{
			$gameScore->save();
		  	echo $gameScore->get("score") . "<br>";
		}catch(ParseException $ex){

		}
	}

	public function query_object()
	{

	}

}
