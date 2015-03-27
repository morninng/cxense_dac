@extends('presslayout')

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

    <div id="matome"></div>


@stop