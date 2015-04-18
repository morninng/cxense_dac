@extends('parseauthlayout')


@section('main_content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><h2><strong> Edit &nbsp;&nbsp;  {{$user_name}} 's profile </strong></h2></div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif



<form class="form-horizontal" action="/editprofile" method="post">
	<input type="hidden" name="_token" value="{{ csrf_token() }}">
	<input id="cxenseid_hiddenform" type="hidden" name="cxid">

	<div class="form-group">
		<label class="col-md-4 control-label">gender</label>
		<div class="col-md-6">
			&nbsp;<input type="radio"  name="gender" value="male">male&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio"  name="gender" value="female">female
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">age</label>
		<div class="col-md-6">
			<select name="age" class="selectpicker">
  				<option value="0-15">0-15</option>
				<option value="16-30">16-30</option>
				<option value="31-45">31-45</option>
				<option value="46-60">46-60</option>
				<option value="61-100">61-100</option>
			</select>
		</div>
	</div>

	<div class="form-group">
		<label class="col-md-4 control-label">status</label>
		<div class="col-md-6">
			&nbsp;<input type="radio"  name="status" value="student">student&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio"  name="status" value="working">working&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio"  name="status" value="retired">retired&nbsp;&nbsp;
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-6 col-md-offset-4">
			<button type="submit" class="btn btn-primary">
				set profile
			</button>
		</div>
	</div>

</form>

				</div>
			</div>
		</div>
	</div>
</div>




@stop

@section('call_cxense')
  

<script type="text/javascript" src="http://cdn.cxense.com/cx.js"></script>
<script type="text/javascript">
var cx_id = cX.getUserId();
var parse_id = "{{ $user_id }}";
document.write(parse_id);
document.getElementById('cxenseid_hiddenform').value=cx_id;

</script>
  

<!-- Cxense script begin -->
<script type="text/javascript">
var cX = cX || {}; cX.callQueue = cX.callQueue || [];

if(parse_id && parse_id.length >1){
	cX.callQueue.push(['addExternalId', { 'id': parse_id, 'type': 'dac'}]);
}

cX.callQueue.push(['setSiteId', '1128275557251903601']);
cX.callQueue.push(['sendPageViewEvent']);
</script>
<script type="text/javascript">
(function(d,s,e,t){e=d.createElement(s);e.type='text/java'+s;e.async='async';
e.src='http'+('https:'===location.protocol?'s://s':'://')+'cdn.cxense.com/cx.js';
t=d.getElementsByTagName(s)[0];t.parentNode.insertBefore(e,t);})(document,'script');
</script>
<!-- Cxense script end -->



@stop