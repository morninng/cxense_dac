@extends('dachomelayout')

@section('header_area')

	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Laravel</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/') }}">Home</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<?php if($login_status==0){ ?>
						<li><a href="{{ url('/parselogin') }}">Login</a></li>
						<li><a href="{{ url('/parsesignin') }}">Signin</a></li>
					<?php }else{ ?>
							
						<li><a href="{{ url('/parselogout') }}">Logout</a></li>
						<li><a href="{{ url('/editprofile') }}">edit profile</a></li>
					<?php } ?>
				</ul>
			</div>
		</div>
	</nav>

	<script src="//www.parsecdn.com/js/parse-1.4.2.min.js"></script>


@stop


@section('left_area_context')
	<?php echo  $left_area_context ?>
@stop

@section('article_context')
	<?php echo  $article_context ?>
@stop

@section('side_context')
	<style type="text/css">
		table, td{ border: 1px #2b2b2b solid; }
		th {border:1px #2b2b2b solid; background-color: #e0e0e0; ;}
	</style>
	<table id="trend_keyword_table">
	<caption><center>トレンド</center></caption>
	<tr><th>keyword</th><th>&nbsp;pv&nbsp;</th></tr>
	</table>
    <script src="/js/ShowLink_from_traffic_info_Parse.js"></script>


@stop


