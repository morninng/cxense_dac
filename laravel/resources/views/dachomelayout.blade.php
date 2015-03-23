<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DAC cxense demo</title>

	<link rel="stylesheet" href="/css/reset.css">
	<link rel="stylesheet" href="/css/layout.css">
	<link rel="stylesheet" href="/css/module.css">
	<link rel="stylesheet" href="/css/home.css">

</head>
<body id="home" class="line5">
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


</body>
</html>
