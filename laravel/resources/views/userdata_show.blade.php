@extends('userdata_layout')


@section('main_context')

	


@stop


@section('cxense_script')

<!-- Cxense script begin -->
<script type="text/javascript">
var cX = cX || {}; cX.callQueue = cX.callQueue || [];
cX.callQueue.push(['setSiteId', {{$cxense_site_id}}  ]);
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


<script type="text/javascript">


</script>


@stop
