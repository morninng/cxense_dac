@extends('Matomelayout')

@section('main_context')

 check each word and retrieve the content data for each word.<br>
<hr>

<span id="matome_list"></span>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script type="text/javascript">

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
<script type="text/template" data-template="matome_select_template">
 
<h1> keyword is <%= keyword %> </h1>
  <ul>
     <% _.each(matome_list, function(e,i){ %>
          <li>
            <div class="matome_each_item">
              <div class="matome_check_box_block">
                  <input class="check_box" type="checkbox">
              </div>
              <div class="matome_description">
                <p> title <strong><a href="<%= e.url %>"> <%= e.title %> </a></strong></p>
                <p> description <%= e.description %></p>
                <p>site name <%= e.site_name %></p>
                <p> 
                  <span class="border_box"> pv &nbsp&nbsp <%= e.pv %> </span>
                  <span class="border_box"> active time &nbsp&nbsp <%= e.activeTime %> </span>
                  <span class="border_box"> session bounce &nbsp&nbsp <%= e.sessionBounces %> </span>
                </p>
              </div>
              <div class="matome_image">
                <img src="<%= e.img_src %>" style="max-width:100px">
              </div>
            </div>
          </li>
     <% }); %>
  </ul>

</script>

<script type="text/javascript">
  

  var matome_template = _.template($('[data-template="matome_select_template"]').html());

<?php
  foreach ($matome_data_object_array as $matome_data_object){
?> 
  var matome_object = new Object();
  matome_object["keyword"] = "{{$matome_data_object['keyword']}}";
  var matome_list = new Array();
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


