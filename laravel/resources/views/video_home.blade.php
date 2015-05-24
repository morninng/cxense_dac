@extends('videolayout')

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
                    <li><a href="{{ url('/video') }}">Video</a></li>
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

@section('left_area_context')
	<?php echo $leftbar_context_converted ?>
@stop

@section('video_main')
	<p><a href=/video/4106619707001>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;video context1 </a></p>
    <p><a href=/video/4106619708001>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;video context2 </a></p>
@stop

