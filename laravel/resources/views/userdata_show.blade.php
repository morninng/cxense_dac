@extends('userdata_layout')


@section('main_context')

	<style type="text/css">
		table { border:solid; }
		td { border: solid thin; }
	</style>

	<span id = "parse_data"></span>
	<br>
	<table >
	<tr><th>item</th><th>group</th><th>weight</th></tr>

	<?php
		foreach ($user_profile_array as $user_profile){
			$user_item = $user_profile->{'item'};
			$user_group_array = $user_profile->{'groups'};
			echo "<tr><td>" . $user_item . "</td>";
			foreach ($user_group_array as $user_group){
			//	$count =  $user_group->{'count'};
			//	echo "count is " . $count . "<br>";
				$group =  $user_group->{'group'};
				echo "<td>" . $group . "</td>";
				$weight =  $user_group->{'weight'};
				echo "<td>" . $weight . "</td>";
			}
			echo "</tr>";
		}
	?>

	</table>


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
 

@stop

@section('page_script')


<script> 
  Parse.initialize("EWPPdrDVaAIqhRazWp8K0ZlmafAAPt93JiOAonvX", "US6Lheio8PGcBdIpwGFhFSQVpi5GKunGf6hGq5Ze");
  var user_parse_id = "{{$user_parse_id}}";

	var User = Parse.Object.extend("User");
	var user_query = new Parse.Query(User);
	user_query.get(user_parse_id, {
	  success: function(user_obj) {
	  	var user_name = user_obj.get('username');
	  	console.log(user_name);
	  },
	  error: function(object, error) {
	  }
	});

</script>

@stop

