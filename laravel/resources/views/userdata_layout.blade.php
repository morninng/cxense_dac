<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>cxense solution presen demo</title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script type="text/javascript" src="http://www.parsecdn.com/js/parse-1.4.0.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="http://cdn.cxense.com/cx.js"></script>
	
</head>
<body id="home" class="line5">



	<div id="mainArea">
		<article>
			@yield('main_context')
		</article>
	</div>


	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>


	@yield('cxense_script')
	@yield('page_script')

</body>
</html>
