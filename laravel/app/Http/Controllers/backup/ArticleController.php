<?php namespace App\Http\Controllers;


include(app_path().'/Http/Controllers/simple_html_dom.php');

class ArticleController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	
	public function index()
	{
		$url = "http://www.dac.co.jp/press/2015/201503-modulo.html";
		$html_context = file_get_html($url);
		$article_context = $html_context->find("section")[0];

		return view('article')->with("html_context",$article_context);

	}

}
