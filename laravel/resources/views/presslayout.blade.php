<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>DAC cxense demo</title>

	<link rel="stylesheet" href="/css/reset.css">
	<link rel="stylesheet" href="/css/layout.css">
	<link rel="stylesheet" href="/css/module.css">

</head>
<body>
	<div id="wrapper">
		<div id="mainArea">
			<article>
				@yield('title_context')
				@yield('article_content')
				<div id="kannrenn_kiji">
					@yield('cxense_kannrenn');
				</div>
			</article>
		</div>
	@yield('leftbar_context')

	</div>
	<div id="side">

	</div>


</body>
</html>
