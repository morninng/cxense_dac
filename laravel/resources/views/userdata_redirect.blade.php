@extends('userdata_layout')

@section('main_context')


@stop


@section('cxense_script')

<script>
 var cxense_script_siteid = "{{$cxense_site_id}}" ;
 var parse_user_id = "{{$user_parse_id}}";
</script>


<!-- Cxense script begin -->
<script type="text/javascript">
var cX = cX || {}; cX.callQueue = cX.callQueue || [];
cX.callQueue.push(['addExternalId', { 'id': parse_user_id, 'type': 'dac'}]);
cX.callQueue.push(['setSiteId', cxense_script_siteid ]);
cX.callQueue.push(['sendPageViewEvent']);
</script>
<script type="text/javascript">
(function(d,s,e,t){e=d.createElement(s);e.type='text/java'+s;e.async='async';
e.src='http'+('https:'===location.protocol?'s://s':'://')+'cdn.cxense.com/cx.js';
t=d.getElementsByTagName(s)[0];t.parentNode.insertBefore(e,t);})(document,'script');
</script>
<!-- Cxense script end -->

cxense id is
{{$cxense_site_id}}  
<br>
user parse id is
{{$user_parse_id}}
<br>
redirect url is 
{{$redirect_url}}
<br>
<br>
This page will be redirected in 3 seconds
<script type="text/javascript">
	 setTimeout( function(){ redirect(); },50);

	function redirect(){
		window.location.href = "{{$redirect_url}}";
	}

</script>

@stop
