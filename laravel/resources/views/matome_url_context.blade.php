@extends('Matomelayout')

@section('main_context')

 chose the article which you want to show on matome site<br>
<hr>

<button onclick="generate_matome()"> generate matome site </button>
<button onclick="delete_matome()"> delete all the data on matome </button>

<span id="matome_list"></span>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>


<script src="//www.parsecdn.com/js/parse-1.4.2.min.js"></script>

<script type="text/javascript">
  Parse.initialize("ErYnBqEmLR7KbYBSUUwN8LmFgqNY1TpxpCajNP9o", "xzNZRy8xJsxKda2snnLcx9xsAo49DQrKnbIQ7CPH");
</script>

<style>
.matome_each_item{
  border: 1px solid #000000;
  display:flex;
  align-items:stretch;
}
.matome_check_box_block{
  border: 1px solid #000000;
  width: 30px;
}
.check_box{
    vertical-align: middle;
}

.matome_image{
  border: 1px solid #000000;
  width: 120px;
}
.matome_description{
  border: 1px;
  solid #000000;
  flex:1;
}

</style>
<script>
function generate_matome(){

  var save_promise = new Array();
  var save_urlcontext_promise = new Array();

/*
  for(var k=0; k<keyword_list.length; k++){
    var keyword = keyword_list[k];

  //  var matome_keyword = new MatomeKeyword();
    //matome_keyword.set("keyword",keyword)
      save_promise.push(eval("matome_keyword_" + keyword + ".save()"));
    //save_promise.push(matome_keyword.save());
  }
  Parse.Promise.when(save_promise).then(function(){
*/
  for( var i=0; i< keyword_list.length; i++){
    var keyword = keyword_list[i];
    var MatomeKeyword = Parse.Object.extend("MatomeKeyword");
    var matome_keyword = new MatomeKeyword();
    matome_keyword.set('keywordlist',keyword);
    var url_content_array = eval("document." + keyword + ".elements");

    for(var j=0; j<url_content_array.length; j++ ){
      if( url_content_array[j].checked ){
        var MatomeContext = Parse.Object.extend("MatomeContext");
        var matome_context = new MatomeContext();
        matome_context.set("context_keyword",keyword);
        matome_context.set("title",all_matome_data_array[i][j]["title"]);  
        matome_context.set("url",all_matome_data_array[i][j]["url"]);  
        matome_context.set("img_src",all_matome_data_array[i][j]["img_src"]);
        matome_context.set("descript",all_matome_data_array[i][j]["description"]); 
        matome_keyword.add("matome_context", matome_context);
      }
    }
    save_urlcontext_promise.push( matome_keyword.save() );
  }
  Parse.Promise.when(save_urlcontext_promise).then(function(){
    console.log("go to matome page");
    location.href = "/matome_site_link";
    

  }, function(error) {
  // This isn't called because the error was already handled.
    console.log("fail with" + error);
  });
  
/*
  
  for( var i=0; i< keyword_list.length; i++){
    var keyword = keyword_list[i];
    console.log(keyword);
    var url_content_array = eval("document." + keyword + ".elements");
    for(var j=0; j<url_content_array.length; j++ ){
      if( url_content_array[j].checked ){
        console.log(url_content_array[j].value);
        console.log(keyword);
        console.log(all_matome_data_array[i][j]["title"]);
        console.log(all_matome_data_array[i][j]["url"]);
        console.log(all_matome_data_array[i][j]["img_src"]);
        console.log(all_matome_data_array[i][j]["description"]);
      }
    }
  }
  */

}

</script>
<script type="text/template" data-template="matome_select_template">
 
<h1> keyword is <%= keyword %> </h1>
  <form name = "<%= keyword %>">
    <ul style="list-style:none;">
       <% _.each(matome_list, function(e,i){ %>
            <li>
              <div class="matome_each_item">
                <div class="matome_check_box_block">
                    <input class="check_box" type="checkbox" value="<%= i %>">
                </div>
                <div class="matome_description">
                  <p> title <strong><a href="<%= e.url %>" target="_blank"> <%= e.title %> </a></strong><br>
                   description <%= e.description %><br>
                   site name <%= e.site_name %></p>
                  <p> 
                    <span class="border_box"> pv &nbsp <%= e.pv %>&nbsp&nbsp&nbsp&nbsp</span>
                    <span class="border_box"> active time :&nbsp <%= e.activeTime %>&nbsp&nbsp&nbsp&nbsp </span>
                    <span class="border_box"> session bounce :&nbsp <%= e.sessionBounces %>&nbsp&nbsp&nbsp&nbsp </span>
                  </p>
                </div>
                <div class="matome_image">
                  <img src="<%= e.img_src %>" style="max-width:100px">
                </div>
              </div>
            </li>
       <% }); %>
    </ul>
  </form>

</script>

<script type="text/javascript">
  

  var matome_template = _.template($('[data-template="matome_select_template"]').html());
  var keyword_list = new Array();
  var all_matome_data_array = new Array();
<?php
  foreach ($matome_data_object_array as $matome_data_object){
?> 
  var matome_object = new Object();
  matome_object["keyword"] = "{{$matome_data_object['keyword']}}";
  var matome_list = new Array();
  keyword_list.push("{{$matome_data_object['keyword']}}");

  <?php
    foreach ($matome_data_object["list_data"] as $matome_data){
  ?> 
      var each_obj = new Object();
      each_obj["title"] = "{{$matome_data->title}}";
      each_obj["url"] = "{{$matome_data->url}}";
      each_obj["img_src"] = "{{$matome_data->image}}";
      each_obj["description"] = "{{$matome_data->description}}";
      each_obj["site_name"] = "{{$matome_data->site_name}}";
      each_obj["pv"] = "{{$matome_data->events}}";
      each_obj["activeTime"] = "{{$matome_data->activeTime}}";
      each_obj["sessionBounces"] = "{{$matome_data->sessionBounces}}";
      matome_list.push(each_obj);
  <?php
    }
  ?> 
  all_matome_data_array.push(matome_list);
  console.log(matome_list);
  matome_object["matome_list"] = matome_list;
  var matome_html = matome_template(matome_object);
  $("#matome_list").append(matome_html);
<?php
  }
?>

</script>



<!--
  <?php
    foreach ($matome_data_object_array as $matome_data_object){
  ?> 
    <h1> keyword is {{$matome_data_object["keyword"]}} </h1>
      <ul>
      <?php
        foreach ($matome_data_object["list_data"] as $matome_data){
      ?> 
      <li>
        <div class="border_box">
          <p> title <strong><a href="{{$matome_data->url}}"> {{$matome_data->title}}</a></strong></p>
          <img src="{{$matome_data->image}}" style="max-width:100px">
          <p> description {{$matome_data->description}}</p>
          <p>site name {{$matome_data->site_name}}</p>
          <p> 
            <span class="border_box"> pv &nbsp&nbsp{{$matome_data->events}} </span>
            <span class="border_box"> active time &nbsp&nbsp{{$matome_data->activeTime}} </span>
            <span class="border_box"> session bounce &nbsp&nbsp{{$matome_data->sessionBounces}} </span>
           </p>
        </div>
      </li>

      <?php
        }
      ?> 
      </ul>
  <?php
    }
  ?>
-->



@stop


