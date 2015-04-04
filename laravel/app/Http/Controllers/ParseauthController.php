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
		session_start();
		ParseClient::initialize( 'ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o' 
								, 'b1qSJHLREpVGSWctgzaYFf2FBitfwgXE99B6un9B'
								, 'uO1sGxKOAIL3hydGNW8NmLXKYxIeKrpPbLtuVbnH' );

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
		// print_r($_SESSION);

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

	public function editprofile()
	{
		$currentUser = ParseUser::getCurrentUser();
		$user_name = $currentUser->get("username");
		return View('parseeditprofile')
				->with("user_name",$user_name);
	}


	public function post_editprofile()
	{
		$currentUser = ParseUser::getCurrentUser();
		$currentUser->set("gender", $_POST['gender']);
		$currentUser->set("age", $_POST['age']);
		$currentUser->set("status", $_POST['status']);
		try{
			$currentUser->save();
		} catch (ParseException $ex) { 
			echo 'Failed to save profil, with error message: ' + $ex->getMessage();
		}



		return Redirect::to('/');
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


		return Redirect::to('/');
	}

	public function getLogout()
	{
		$currentUser = ParseUser::getCurrentUser();
		if($currentUser){
			echo "current user set";
		}else{
			echo "current user not set";
		}
		echo "<br>";
		print_r($_SESSION);echo "<br>";

		ParseUser::logOut();

		return Redirect::to('/parselogin');

	}
}
