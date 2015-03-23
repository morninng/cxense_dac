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
    
    <script type="text/javascript">
    var keyword_matome_array = [];
    <?php  
        foreach($url_array as  $url ){
            print("keyword_matome_array.push('" . $url . "');");
        }
    ?>
  //  document.write(keyword_matome_array[0] + "<br>");
  //  document.write(keyword_matome_array[1] + "<br>");
  //  document.write(keyword_matome_array[2] + "<br>");
    </script>


    <div id="matome">
    <?php
        foreach($link_array as  $link ){ ?>
            <div class="matome_link">
             <a href={{$link["url"]}}>
              <img src={{$link["thumbnail_url"]}} width={{$link["thumbnail_width"]}} height={{$link["thumbnail_height"]}} >
                {{$link["title"]}}
               <h4></h4>
             </a>
            </div>
            <hr size="10">
            <br>
    <?php
        }
    ?>
    </div>
   

@stop