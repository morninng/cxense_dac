<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DAC cxense demo</title>
	@include('common.header')
</head>
<body>
	@yield('header_area')

	<div id="wrapper">
		<div id="mainArea">
			<article>
				<div>
					@yield('title_context')
					@yield('article_content')
				</div>
			</article>
			<div id="kannrenn_kiji">
				@yield('cxense_kannrenn')
			</div>
		</div>
	@yield('leftbar_context')

	</div>

	<div id="side">
	</div>

	<footer style="position: static;">
		@include('common.footer')
	</footer>

	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

</body>
</html>
