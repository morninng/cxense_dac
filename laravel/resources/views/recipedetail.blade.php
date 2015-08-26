@extends('excitelayout')


@section('header_context')
<?php echo $header_html ?>
 
@endsection


@section('content_head')
<?php echo $headerwrapper_html ?>
<?php echo $headerad_html ?>
<?php echo $navigation_html ?>
<?php echo $search_sub_html ?>
 
@endsection


@section('above_kannrenn')
<?php echo $mansion_kanto_html ?>
<?php echo $bread_box_html ?>
<?php echo $hrecipe_html ?>
<?php echo $roundbox_free_html ?>
<?php echo $copyright_html ?>
<?php echo $brdrbox_mT10_html ?>
@endsection


@section('below_kannrenn')

<?php echo $mT10_mB10html ?> 
@endsection


@section('right_above')
<?php echo $osusume_context_html ?>
@endsection


@section('right_middle')

<?php echo $otherrecipe_context_html ?>

@endsection


@section('right_below')

@endsection




@section('original_script')
	

<script type="text/template" data-template="cxense_userlike_template">

	  <h2>あなたへのおすすめ料理</h2>
	  <ul class="thmblist">
	    <div class="simply-scroll simply-scroll-container">
	    <div class="simply-scroll-clip">
	    <div class="simply-scroll simply-scroll-container">
	    <div class="simply-scroll-clip">
	    <div id="slider" class="simply-scroll-list" style="height: 1548px;">

		 <% _.each(list, function(e,i){ %>
			<li><a href="<%= e.link_url %>" class="recipename">
				<span class="thmbwrapright"><img src="<%= e.img_src_url %>" width="115"></span><%= e.link_title %></a>
			</li>
		 <% }); %>
	  </ul>

</script>



<script type="text/template" data-template="cxense_kannrenn_template">

	<h2 class="bigger mT10 mL10 remark">この記事を読んだ人が読んだ別の記事</h2><ul class="tilelist col5 pT10">
		<% _.each(list, function(e,i){ %>
			<li><a href="<%= e.link_url %>" class="recipename"><img src="<%= e.img_src_url %>" width="116" class="recipeimg"> <%= e.link_title %> </a></li>
		<% }); %>
	</ul>

</script>


<script type="text/template" data-template="cxense_ranking_template">

	<h2>トレンドのレシピ</h2>
		<ol class="thmblist">
		<% _.each(list, function(e,i){ %>
			<li class="no1 rcpnm"><span><%= e.ranking %></span><a href="<%= e.link_url %>" class="recipename"><%= e.link_title %></a></li>
		<% }); %>
		</ol>

</script>


	
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<script type="text/javascript" src=/js/cxense_content_rec_v2.js></script>

@endsection
