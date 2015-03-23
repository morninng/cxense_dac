@extends('dachomelayout')

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
	<table>
	<caption><center>トレンド</center></caption>
	<tr><th>keyword</th><th>page数</th><th>pv</th></tr>
	<?php 
		$i=0;
		foreach($site_concept_array as $each_concept){
			echo("<tr><td>");
			echo($each_concept);
			echo("</td><td>");
			echo($site_concept_num_url_array[$i]);
			echo("</td><td>");
			echo($site_concept_num_pv_array[$i]);
			echo("</td></tr>");
			$i++;
		}
	?>
	</table>
@stop

