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

<!-- Cxense content widget: dac_web_widget -->
<div id="cx_7d5d10191a350a2737f13a0cc7001fe71505da48" style="display:none"></div>
<script type="text/javascript">
    var cX = cX || {}; cX.callQueue = cX.callQueue || [];
    cX.callQueue.push(['insertWidget', {
        widgetId: '7d5d10191a350a2737f13a0cc7001fe71505da48',
        insertBeforeElementId: 'cx_7d5d10191a350a2737f13a0cc7001fe71505da48',
        width: 969, height: 225, renderTemplateUrl: 'auto'
    }]);

    // Async load of cx.js
    (function(d,s,e,t){e=d.createElement(s);e.type='text/java'+s;e.async='async';
    e.src='http'+('https:'===location.protocol?'s://s':'://')+'cdn.cxense.com/cx.js';
    t=d.getElementsByTagName(s)[0];t.parentNode.insertBefore(e,t);})(document,'script');
</script>
<!-- End of Cxense content widget -->

@stop