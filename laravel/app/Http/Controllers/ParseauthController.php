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

use Illuminate\Support\Facades\Redirect;

class ParseauthController extends Controller {

// use Laravel\Input\Request\Access\DataProvider;
// use Laravel\Input\Request\Access\DataProvider\DogBreed;

	/**
	 * Create a new controller instance.
	 * @return void
	 */

	public function __construct()
	{

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

		try {
		  $user = ParseUser::logIn($name, $password);
		  echo "login succeed";
		  // Do stuff after successful login.
		} catch (ParseException $error) {
		  // The login failed. Check error to see why.
				  echo "Error: " . $error->getCode() . " " . $error->getMessage();
		};		

	}

	public function getLogout()
	{

	}

}
