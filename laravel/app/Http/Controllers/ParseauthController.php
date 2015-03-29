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
use Parse\ParseSessionStorage;

use Illuminate\Support\Facades\Redirect;

class ParseauthController extends Controller {

	/**
	 * Create a new controller instance.
	 * @return void
	 */

	public function __construct()
	{

		echo "-session start<br>";
		session_start();

		echo "initialization of parse called <br>";

		ParseClient::initialize( 'ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o' 
								, 'b1qSJHLREpVGSWctgzaYFf2FBitfwgXE99B6un9B'
								, 'uO1sGxKOAIL3hydGNW8NmLXKYxIeKrpPbLtuVbnH' );

	//	$this->middleware('auth');
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	public function getSignin()
	{
		return view('parsesignin');
	}

	public function postSignin()
	{
		$errors = array();
		$name = $_POST['name'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm_passowrd = $_POST['password_confirmation'];
		if($password != $password){
			array_push($errors, "password is not the same");
		}
		print_r($_SESSION);
		ParseClient::setStorage( new ParseSessionStorage() );

		if(count($errors)==0){
			$user = new ParseUser();
			$user->set("username", $name);
			$user->set("password", $password);
			$user->set("email", $email);
			try {
			  $user->signUp();
			  // Hooray! Let them use the app now.
				echo "user info is registered on parse.com";
				return Redirect::to('/registuser');

			} catch (ParseException $ex) {
			  // Show the error message somewhere and let the user try again.
			  echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
			}
		}
		return ;
	}

	public function getLogin()
	{
		return View('parselogin');
	}

	public function postLogin()
	{
		$name = $_POST['name'];
		$password = $_POST['password'];

		print_r($_SESSION);echo "<br>";
		var_dump($_SESSION);echo "<br>";
		$storage = new ParseSessionStorage();
		ParseClient::setStorage( $storage );

		try {
		  $user = ParseUser::logIn($name, $password);
		  echo "login succeed<br><br>";
		} catch (ParseException $error) {
				  echo "Error: " . $error->getCode() . " " . $error->getMessage();
		};

		$currentUser = ParseUser::getCurrentUser();
		if($currentUser){
			echo "current user set<br>";
			$sessionToken = $currentUser->getSessionToken();
			echo $sessionToken . "<br>";
		}else{
			echo "current user not set<br>";
		}
		print_r($_SESSION);echo "<br>";
		var_dump($_SESSION);echo "<br>";
	}

	public function getLogout()
	{
		$currentUser = ParseUser::getCurrentUser();
		if($currentUser){
			echo "current user set";
		}else{
			echo "current user not set";
		}
		echo "<br><br>";
		print_r($_SESSION);echo "<br>";
		var_dump($_SESSION);echo "<br>";
	}
}
