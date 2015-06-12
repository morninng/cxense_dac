<?php namespace App\Http\Controllers;

class SolutionController extends Controller {


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

	public function show_user_data_bikebros($user_parse_id)
	{
		$bikebros_cxense_id = "1130531920128972215";
		retrieve_user_data($bikebros_cxense_id, $user_parse_id);
		
		return view('userdata_show')
				->with("user_parse_id",$user_parse_id)
				->with("cxense_site_id",$bikebros_cxense_id);
	}

	public function show_user_data_dac($user_parse_id)
	{
		$dac_cxense_id = "1128275557251903601";
		$this->retrieve_user_data($dac_cxense_id, $user_parse_id);

		return view('userdata_show')
				->with("user_parse_id",$user_parse_id)
				->with("cxense_site_id",$dac_cxense_id);
	}

	public function bikebros_redirect($user_parse_id)
	{

		$bikebros_cxense_id = "1130531920128972215";
		$redirect_url = "/solution_dac_redirect/" . $user_parse_id;

		return view('userdata_redirect')
				->with("user_parse_id",$user_parse_id)
				->with("redirect_url",$redirect_url)
				->with("cxense_site_id",$bikebros_cxense_id);
	}

	public function dac_redirect($user_parse_id)
	{
		$dac_cxense_id = "1128275557251903601";
		$redirect_url = "/show_user_data_dac/" . $user_parse_id;

		return view('userdata_redirect')
				->with("user_parse_id",$user_parse_id)
				->with("redirect_url",$redirect_url)
				->with("cxense_site_id",$dac_cxense_id);
	}

	public function people_list()
	{
		return view('solution_home');
	}


	public function retrieve_user_data($cxense_id, $user_parse_id){

		$url_array = array();

		$keyword = "dac";
		$username="cxense-team@dac.co.jp";
		$apikey="api&user&Qkc0a6QqYvTPjOsYbhR7Sg==";
		$date = date("Y-m-d\TH:i:s.000O");
		$signature=hash_hmac("sha256", $date, $apikey);
		$url = 'https://api.cxense.com/profile/user/external/read';

		echo("signature  :" . $signature); echo("<br><br>");
		$plainjson_payload = "{\"id\":\"$user_parse_id\", \"type\":\"dac\" }";

		echo("payload  :" . $plainjson_payload);echo("<br><br>");

		$options = array(
		    'http' => array(
		        'header'  => "Content-Type: application/json; charset=UTF-8\r\n".
		                     "X-cXense-Authentication: username=$username date=$date hmac-sha256-hex=$signature\r\n",
		        'method'  => 'POST',
		        'content' => $plainjson_payload,
		    ),
		);
		$context  = stream_context_create($options);
		$user_profile   = file_get_contents($url, false, $context);
		$obj = json_decode($user_profile);
		$user_data_array = $obj->{'data'};

		var_dump($obj);
		var_dump($user_data_array);


		echo("<br>obj<br>");
		echo("<br>result<br>");



	}



}


