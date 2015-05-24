<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DAC cxense demo</title>

		@include('common.homeheader')

</head>
<body id="home" class="line5">

	@yield('header_area')

	<div id="wrapper">
		<div id="leftArea">
				@yield('left_area_context')
		</div>
		<div id="mainArea">
			<article>
				@yield('article_context')
			</article>
			<div id="side">
				<div>
				@yield('side_context')
				</div>
			</div>
		</div>
	</div>

	<footer style="position: static;">
		@include('common.footer')
	</footer>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://www.parsecdn.com/js/parse-1.4.0.min.js"></script>
	<script src="/js/parse_login_confirm_test.js"></script>

</body>
</html>
