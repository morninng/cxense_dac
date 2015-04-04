@extends('presslayout')


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
@stop


@section('leftbar_context')
	<?php echo $leftbar_context ?>
@stop

@section('title_context')
    <?php echo $title_context ?>
@stop


@section('article_content')
	<?php echo $article_context ?>
@stop

@section('cxense_kannrenn')
    
    <div id="matome"></div>
    <script type="text/javascript" src="http://cdn.cxense.com/cx.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">
    var keyword_matome_array = [];
    <?php  
        foreach($url_array as  $url ){
            print("keyword_matome_array.push('" . $url . "');");
        }
    ?>
    </script>
    <script src="/js/ShowLink_from_content_fetch.js"></script>
    


@stop