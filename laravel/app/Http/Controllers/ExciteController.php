<?php namespace App\Http\Controllers;


include(app_path().'/Http/Controllers/lib/simple_html_dom.php');
// require_once 'Benchmark/Timer.php';

class ExciteController extends Controller {


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
		return view('home');
	}

	public function detail($recipe_id)
	{

		echo "detail";
// $timer2 = new \Benchmark_Timer(TRUE);

		$excite_detail_url = "http://erecipe.woman.excite.co.jp/detail/" . $recipe_id;
		echo $excite_detail_url;
		$html_context = file_get_html($excite_detail_url);
		 echo "html_context";

// $timer2->setMarker('html context get');

		$header_html = $html_context->find('head')[0];

		$headerwrapper_html = $html_context->find('div[id=headerwrapper]')[0];
		$headerad_html = $html_context->find('div[id=headerad]')[0];
		$navigation_html = $html_context->find('div[id=navigation]')[0];
		$search_sub_html = $html_context->find('div[id=search_sub]')[0];

		$mansion_kanto_html = $html_context->find('div[id=mansion_kanto]')[0];
		$bread_box_html = $html_context->find('div[id=bread_box]')[0];
		$hrecipe_html = $html_context->find('div[class=hrecipe]')[0];
		$roundbox_free_html = $html_context->find('div[class=roundbox_free c_coffee p10 ovH mT10 vcard posrltv]')[0];
		$copyright_html = $html_context->find('p[class=copyright]')[0];
		$brdrbox_mT10_html = $html_context->find('div[class=brdrbox mT10]')[1];
		$mT10_html = $html_context->find('div[class=mT10]')[8];
		$mT10_mB10html = $html_context->find('div[class=mT10 mB10]')[0];


		$osusume_context_html = $html_context->find('div[id=sub] > div[class=relate mT10 mB10]')[0];

		$otherrecipe_context_html = $html_context->find('div[id=sub] > div[class=relate mT10]')[1];

// $timer2->stop();
//$timer2->display();

		return view('recipedetail')
				->with("header_html",$header_html)
				->with("headerwrapper_html",$headerwrapper_html)
				->with("headerad_html",$headerad_html)
				->with("navigation_html",$navigation_html)
				->with("search_sub_html",$search_sub_html)
				->with("mansion_kanto_html",$mansion_kanto_html)
				->with("bread_box_html",$bread_box_html)
				->with("hrecipe_html",$hrecipe_html)
				->with("roundbox_free_html",$roundbox_free_html)
				->with("copyright_html",$copyright_html)
				->with("brdrbox_mT10_html",$brdrbox_mT10_html)
				->with("mT10_html",$mT10_html)
				->with("mT10_mB10html",$mT10_mB10html)
				->with("osusume_context_html",$osusume_context_html)
				->with("otherrecipe_context_html",$otherrecipe_context_html);
	}
}
