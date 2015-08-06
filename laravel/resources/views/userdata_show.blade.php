@extends('userdata_layout')


@section('main_context')

	<style type="text/css">
		table { border:solid; }
		td { border: solid thin; }
	</style>

	<span id = "parse_data"></span><br><br><br>
	<br>
	<table >
	<caption>data retrieved by profile-user</caption>
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

	<br>
	<table >
	<caption>data retrieved by traffic keyword</caption>
	<tr><th>item</th><th>group</th><th>weight</th></tr>

	<?php
		foreach ($user_traffic_keyword_array as $group){
			$group_group = $group->{'group'};
			echo "<tr><td>" . $group_group . "</td>";
			$group_items_array = $group->{'items'};

			foreach ($group_items_array as $group_item){
				$item = $group_item->{'item'};
				echo "<td>" . $item . "</td>";
			}
			echo "</tr>";
		}
	?>




	<br>
	<table >
	<caption>data retrieved by traffic event</caption>
	<tr><th>item</th><th>group</th><th>weight</th></tr>

	<?php
		foreach ($user_traffic_event_array as $group){
			$group_group = $group->{'group'};
			echo "<tr><td>" . $group_group . "</td>";
			$group_items_array = $group->{'items'};

			foreach ($group_items_array as $group_item){
				$item = $group_item->{'item'};
				echo "<td>" . $item . "</td>";
			}
			echo "</tr>";
		}
	?>

	</table>
	</br>

<p>link to other company data </p>

<a href="/show_user_data_dac/{{$user_parse_id}}"> dac site data </a><br>
<a href="/show_user_data_bikebros/{{$user_parse_id}}"> bikebros site data </a>


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

<script type = "text/template" data-template="user_parse_info_template">
  <div  style='float:left;border:solid 1px;  padding: 5px;' >
      <div  style="float:left; margin-left:5px;">
        <img src="<%=picture_src %>">
      </div>
     <div style="float:left; margin-left:10px;">
      <%= first_name %>  &nbsp;  <%= last_name  %> 
      </div>
   </div>
</script>




<script> 
  Parse.initialize("EWPPdrDVaAIqhRazWp8K0ZlmafAAPt93JiOAonvX", "US6Lheio8PGcBdIpwGFhFSQVpi5GKunGf6hGq5Ze");
  var user_parse_id = "{{$user_parse_id}}";

	var User = Parse.Object.extend("User");
	var user_query = new Parse.Query(User);
	user_query.get(user_parse_id, {
	  success: function(user_obj) {
	  	var first_name = user_obj.get('FirstName');
	  	var last_name = user_obj.get('LastName');
	  	var profile_picture_src = user_obj.get('Profile_picture');
	  	console.log(first_name);
	  	console.log(last_name);
	  	console.log(profile_picture_src);

	    var data = { first_name: first_name, last_name: last_name, picture_src: profile_picture_src };

	    html_Template = _.template($('[data-template="user_parse_info_template"]').html());
	    var html_text = html_Template(data);
	    var participant_container = $("#parse_data");
	    participant_container.html(html_text);


	  },
	  error: function(object, error) {
	  }
	});

</script>

@stop

