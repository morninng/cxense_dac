@extends('Matomelayout')

@section('main_context')

 check each word and retrieve the content data for each word.<br>
  <button onclick="retrieve_data()">retrieve data</button>
  <br><br><hr>
<script type="text/javascript">

  function retrieve_data(){
    elements_array = document.keyword_list.elements
    var get_param = "";
    for(i=0; i<elements_array.length; i++ ){
      if(elements_array[i].checked){
      //  console.log(elements_array[i].value);
        get_param = get_param + elements_array[i].value + "_";
      }
    }
    var get_param = get_param.substr( 0 , (get_param.length-1) );
    var get_pre_param = "?keyword="
    var url = "/matome_cms_sitelist" + get_pre_param + get_param;
    console.log(url);
    location.href = url;

   // location.href = "/matome_cms_sitelist";
   
  }
</script>


<form name="keyword_list" >

<?php
  foreach ($keyword_array as $keyword){
?> 
    <input type="checkbox" value="{{$keyword}}">{{$keyword}}<br>

<?php
  }
?>

</form>



@stop


